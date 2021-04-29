<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'ticket_type_id',
        'quantity',
    ];
}
