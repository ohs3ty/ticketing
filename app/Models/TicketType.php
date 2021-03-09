<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_name',
        'ticket_cost',
        'ticket_limit',
        'ticket_description',
        'event_id',
        'patron_profile_id',
        'ticket_open_date',
        'ticket_close_date',
    ];
}
