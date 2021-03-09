<?php

namespace App\API;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $primaryKey = "user";
    public $incrementing = false;
    protected $keyType = "string";
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at'
    ];

    protected $fillable = [
        'user',
        'token',
        'expires_at',
    ];

    public function getExpiredAttribute()
    {
        return now()->gt($this->expires_at);
    }

    private static function requestToken($cred)
    {
        $headers = [
            "Authorization" => "Basic " . $cred,
            "Content-Type" => "application/x-www-form-urlencoded",
        ];
        $query = "grant_type=client_credentials";
        $response = (new \GuzzleHttp\Client())->request('POST', 'https://api.byu.edu:443/token', compact('query', 'headers'));

        return API::parseResponse($response);
    }

    private static function refreshToken($user, $cred)
    {
        $old_token = ApiToken::requestToken($cred);
        $token = $old_token->access_token;
        $expires_at = now()->addSeconds($old_token->expires_in)->subMinutes(5);
        $new_token = ApiToken::firstOrCreate(compact('user'));
        $new_token->update(compact('token', 'expires_at'));
        $new_token->save();
        return $new_token;
    }

    public static function getToken($user, $cred)
    {
        static $bad_token = FALSE;
        if ($bad_token) {
            ApiToken::tokenError();
            return null;
        }
        $token = ApiToken::find($user);
        if (is_null($token) || $token->expired)
            $token = ApiToken::refreshToken($user, $cred);
        if (is_null($token)) {
            $bad_token = TRUE;
            return null;
        }
        return $token->token;
    }
}