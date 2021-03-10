<?php

namespace App\Models\People;

use \App\API\Persons;

/**
 * Person ties together the User model and the
 * API funtionality.
 *      It takes in a user object and collects the
 *      information dynamically as it is required and
 *      doesn't make redundant api calls.
 *
 * example 1:
 *      $user = \App\Models\People\User::first();
 *      $person = new \App\Person($user);
 *      $person->sex; // 'M'
 *      $person->age; // 21
 *
 * example 2:
 *      $user = \App\Models\People\User::first();
 *      $person = $user->person;
 *      $person->sex; // 'F'
 *      $person->age; // 12
 *
 */
class Person
{
    public function __construct(User $user)
    {
        $this->nulls = [];
        if (!$user->byu_id) {
            $infos = (new \App\API\API())->getPersonByNetID($user->net_id);
            $this->set_infos($infos);
            if ($this->byu_id) {
                $user->byu_id = $this->byu_id;
                if ($user->id)
                    $user->save();
            }
        } else
            $this->byu_id = $user->byu_id;
    }

    public function set_null_keys($items)
    {
        foreach (Persons::ITEMS[$items] as $item)
            $this->nulls[] = $item;
    }

    public function __get($key)
    {
        // \Log::info($key);
        if (!isset($this->byu_id) || in_array($key, $this->nulls))
            return null;
        if ($key == 'photo')
            return $this->photo();
        if ($key == 'groups')
            return $this->groups();
        $has_item = key_exists($key, Persons::ACCESS_ITEM);
        if ($has_item) {
            $infos = (new Persons())->getDataByItem($key, $this->byu_id);
            $this->set_infos($infos, Persons::ACCESS_ITEM[$key]);
            if (isset($this->$key))
                return $this->$key;
            $key2 = Persons::ACCESS_ITEM[$key];
            if (isset($this->$key2))
                return $this->$key2->first()->$key ?? null;
            $this->set_null_keys($key2);
        }
        $has_items = key_exists($key, Persons::ITEMS);
        if ($has_items) {
            $infos = (new Persons())->getDataByItems($key, $this->byu_id);
            $this->set_infos($infos, $key);
            if (isset($this->$key))
                return $this->$key;
            $this->set_null_keys($key);
        }
        return null;
    }

    private function set_infos($infos, $key = null)
    {
        if ($infos) {
            foreach ($infos as $k => $info) {
                if ($k === 'basic')
                    $this->set_infos($info, $key);
                else {
                    if (is_array($info)) {
                        if ($key && !isset($this->$key))
                            $this->$key = collect([]);
                        $this->$key[] = (object) $info;
                    } else {
                        $this->$k = $info;
                    }
                }
            }
        } else
            $this->nulls[] = $key;
    }

    public function photo()
    {
        if (isset($this->photo))
            return $this->photo;
        $photo = \App\API\Photos::getDataByByuID($this->byu_id);
        $this->photo = $photo;
        return $photo;
    }

    public function groups()
    {
        if (isset($this->groups))
            return $this->groups;
        $groups = $this->group_memberships;
        if (!is_null($groups))
            return implode(',', $groups->pluck('group_id')->toArray());
        $this->groups = $groups;
        return $groups;
    }
}
