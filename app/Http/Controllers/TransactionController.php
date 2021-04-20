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
        $ticket_types = TicketType::select("ticket_types.id", "ticket_name", "ticket_cost", "ticket_limit", "ticket_description", "event_id", "patron_profile_id", "ticket_open_date", "ticket_close_date",
                                        DB::raw('COUNT(ticket_types.id) AS ticket_type_count'))
                            ->where('event_id', $request->event_id)
                            ->leftJoin('transaction_tickets', 'transaction_tickets.ticket_type_id', '=', 'ticket_types.id')
                            ->groupBy("ticket_types.id", "ticket_name", "ticket_cost", "ticket_limit", "ticket_description", "event_id", "patron_profile_id", "ticket_open_date", "ticket_close_date")
                            ->get();

        return view('transaction.buy_ticket', [
            "ticket_types" => $ticket_types,
        ]);
    }
}
