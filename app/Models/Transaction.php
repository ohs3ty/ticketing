<?php

namespace App\Models;

use App\Scopes\NameOrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_total',
        'customer_id',
        'status',
    ];

    public $incrementing = false;

    const CASHNET_FORM_URL = 'https://commerce.cashnet.com/';
    const CASHNET_STORE_CODE = 'WEBOU';

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED  = 'failed';

    // Interacting with Cashnet

    public function ticket_types() {
        return $this->hasManyThrough(TicketType::class, TransactionTicket::class, 'transaction_id', 'id', 'id', 'ticket_type_id');
    }

    public function transaction_tickets() {
        return $this->hasMany(TransactionTicket::class);
    }

}
