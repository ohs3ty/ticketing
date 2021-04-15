<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTimes;
use DateInterval;
use DateTime;

class TransactionController extends Controller {
    public function buy_ticket() {

        return view('transaction.buy_ticket');
    }
}
