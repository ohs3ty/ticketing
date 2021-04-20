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

    /**************************v
     * Logging in
     **************************/

    public static function generateByCAS(array $phpCAS){
        if (empty($phpCAS))
            return null;

        $net_id = $phpCAS['user'];

        $user = static::firstOrNew(['net_id' => $net_id]);

        dd($user);
        $attributes = $phpCAS['attributes'] ?? [];
        $user->set_attribute($attributes, 'name', 'name', 'preferred_name', $net_id)
            ->set_attribute($attributes, 'email', 'emailAddress', 'personal_email_address')
            // ->set_attribute($attributes, 'phone', 'phone', 'phone_number')
            ->set_attribute($attributes, 'byu_id', 'byuId', 'byu_id')
            ->set_attribute($attributes, 'memberOf', 'memberOf', 'groups', '', TRUE)
            ->save();
        return $user;
    }

    public function set_attribute(array $attributes, string $name, string $attribute, string $api, $default = null, bool $replace = FALSE)
    {
        if (!isset($this->attributes[$name]) || $replace) {
            if (isset($attributes[$attribute]))
                $this->$name = $attributes[$attribute];
            else if (!is_null($this->person->$api))
                $this->$name = $this->person->$api;
            else
                $this->$name = $default;
        }
        return $this;
    }
}
