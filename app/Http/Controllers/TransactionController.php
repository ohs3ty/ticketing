<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTimes;
use App\Models\TicketType;
use DateInterval;
use DateTime;

class TransactionController extends Controller {
    public function buy_ticket(Request $request) {
        $ticket_types = TicketType::where('event_id', $request->event_id)
                        ->get();

        return view('transaction.buy_ticket', [
            "ticket_types" => $ticket_types,
        ]);
    }
}
