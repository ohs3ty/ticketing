<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCart extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_type_id',
        'ticket_quantity',
        'user_id',
        'session_id',
        'event_id',
    ];
}
