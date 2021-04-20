<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTimes;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use DateInterval;
use DateTime;

class TransactionController extends Controller {
    public function buy_ticket_action(Request $request) {

        return ('success');
    }
}
