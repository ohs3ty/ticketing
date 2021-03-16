<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'net_id',
        'byu_id',
        'memberOf',
        'email',
        'password',
        'phone',
        'has_paid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => 'general',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function get_existing_user($net_id)
    {
        return !is_null($net_id) ? User::where('net_id', $net_id)->first() : null;
    }

    /**************************
     * Logging in
     **************************/

    public static function findUser($phpCAS)
    {
        if (is_null($phpCAS))
        return null;

        $net_id = $phpCAS['user'];

        //copied and pasted from isports (gotta do step by step debugging and coding)
        //also if there are problems, we know approximately where and why
        $user = User::get_existing_user($net_id);
        if (!$user)
            $user = new User(['net_id' => $net_id]);

        $attributes = $phpCAS['attributes'] ?? ['memberOf' => User::ROLES['programmer']];
        if (isset($attributes['memberOf']))
            $user->memberOf = $attributes['memberOf'];
        else
            $user->memberOf = User::ROLES['programmer']; //Cheating
        $user->attribute($attributes, 'name', 'name', 'preferred_name')
            ->attribute($attributes, 'email', 'emailAddress', 'personal_email_address')
            ->attribute($attributes, 'phone', 'phone', 'phone')
            ->attribute($attributes, 'byu_id', 'byuId', 'byu_id')
            ->save();
        return $user;
    }
}
