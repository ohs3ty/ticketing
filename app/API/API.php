<?php

// What Shayna currently understands about this API call
// -api_tokens in database that has user, expiration, and token (what token?)
// -user is most likely the sltevent
// When requesting the token (most likely the one above) we need the cred. The TOKEN_CRED, I'm assuming
// Questions: How do I get the token? How does anybody get the TOKEN_CRED? How do I call the API from my code?
// when do I use the production keys? Do I need to use the production and sandbox keys?



namespace App\API;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;

/**
 * API is a class that pulls data
 * using BYU's provided apis
 *
 * example:
 *      $person = (new \App\API\API())->getPersonByNetID('mynetid');
 *      $byuID = $person['byu_id']
 *      $items = (new \App\API\Persons())->getDataByItem('age', $byuID)
 *      $age = $items['age']
 *
 * Note:
 *      This is used in \App\Person, so you don't have to do that stuff.
 */
class API
{
    const seconds_in_day = 60 * 60 * 24;
    const TOKEN_USER = "sltevent";
    //what do I even put here?
    const TOKEN_CRED = "";


    protected $url = "";

    public static function parseResponse($response)
    {
        switch ($response->getStatusCode()) {
            case 200:
                return json_decode($response->getBody()->getContents());
            default:
                Log::info("API call was bad: " . json_encode($response));
                return null;
        }
    }

    public static function parseBasic($basic)
    {
        $array = [];
        foreach ($basic as $key => $value)
            if (isset($value->value))
                $array[$key] = $value->value;
        return $array;
    }

    public static function parseValues($response)
    {
        if (isset($response->values)) {
            $a = [];
            foreach ($response->values as $value)
                $a[] = API::parseValues($value);
            return $a;
        }
        if (isset($response->basic))
            return API::parseBasic($response->basic);
        else
            return API::parseBasic($response);
    }

    public static function parseByuApiResponse($response)
    {
        $response = API::parseResponse($response);
        if (is_null($response))
            return null;
        return API::parseValues($response);
    }

    public static function getToken()
    {
        return ApiToken::getToken(API::TOKEN_USER, API::TOKEN_CRED);
    }

    public function requestError($method, $uri, $e)
    {
        Log::info("API request failed");
        Log::info("method: " . $method);
        Log::info("url: " . $this->url);
        Log::info("uri: " . $uri);
        Log::info(json_encode($e));
    }

    public function request($method, $url)
    {
        $token = $this->getToken();
        if (!($token || Cache::has($method . $url)))
            return null;
        return Cache::remember($method . $url, API::seconds_in_day, function () use ($method, $url, $token) {
            $headers = [
                "Authorization" => "Bearer " . $token,
                "Accept" => "application/json",
            ];
            try {
                $response = (new \GuzzleHttp\Client())->request($method, $url, compact('headers'));
            } catch (ClientException $e) {
                $this->requestError($method, $url, $e);
                return null;
            } catch (ServerException $e) {
                $this->requestError($method, $url, $e);
                return null;
            }
            return API::parseByuApiResponse($response);
        });
    }

    public function get($uri)
    {
        return $this->request('GET', $this->url . $uri);
    }

    public function getByByuID($byuID, $uri = null, $type = null)
    {
        $url = $byuID;
        if ($uri)
            $url .= '/' . $uri;
        if ($type)
            $url .= '/' . $type;
        return $this->get($url);
    }

    /*
     * This assumes the first person found is the right one for the net_id
     * "Gary Crye
     * About two years ago, John Bench (a developer with the identity team at OIT) said:
     * here is the regex for currently existing net_ids ^[a-z][a-z0-9]{0,8}$
     * this is the regex for creating a new net_id ^[a-z][a-z0-9]{4,7}$ "
     * from byu webcommunity slack. If only there was some damn documentation on the thing.
     */
    public function getPersonByNetID($netID)
    {
        $netID = strtolower($netID);
        if (!preg_match('/^[a-z][a-z0-9]{0,8}$/', $netID)) {
            Log::info("bad netID: " . $netID);
            return null;
        }
        $persons = (new Persons())->get("?net_ids=" . $netID);
        if (empty($persons))
            return null;
        if (count($persons) > 1)
            Log::info('got multiple persons from netID ' . $netID);
        return $persons[0];
    }

    public function getPersonByByuID($byuID)
    {
        while (strlen($byuID) < 9)
            $byuID = 0 . $byuID;

        if (preg_match('/^[0-9]{9}$/', $byuID))
            return $this->getByByuID($byuID);
        Log::info("bad byuID: " . $byuID);
        return null;
    }

    public function getDataByItem($item, $byuID, $type = null)
    {
        $class = get_class($this);
        $items = $class::ACCESS_ITEM;
        if (!in_array($item, array_keys($items))) {
            Log::info($item . " does not exist in " . $class);
            return FALSE;
        }
        $uri = $items[$item];
        $data = $this->getByByuID($byuID, $uri, $type);
        return $data;
    }

    public function getDataByItems($items, $byuID, $type = null)
    {
        $class = get_class($this);
        if (!in_array($items, array_keys($class::ITEMS))) {
            Log::info($items . " does not exist in " . $class);
            return FALSE;
        }
        $uri = $items;
        $data = $this->getByByuID($byuID, $uri, $type);
        return $data;
    }
}
