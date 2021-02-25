<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_name',
        'ticket_cost',
        'ticket_limit',
        'ticket_description',
        'event_id',
        'ticket_type_id',
        'ticket_open_date',
        'ticket_close_date',
    ];
}
