<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_name',
        'venue_addr',
        'venue_zipcode',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
