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

    const CASHNET_FORM_URL = 'https://commerce.cashnet.com/';
    const CASHNET_STORE_CODE = 'WEBOU';

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED  = 'failed';

    // Interacting with Cashnet


}
