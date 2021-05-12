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

    public function getTransactionDate() {
        $date = Carbon::parse($this->created_at)->format('l, F j, Y, g:i a');
        return $date;
    }
}
