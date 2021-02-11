<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_description',
        'start_date',
        'end_date',
        'venue_id',
        'event_type_id',
        'organizer_id',
    ];
}
