<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Models\EventTimes;
use App\Models\TicketType;
use App\Models\TempCart;
use DateInterval;
use DateTime;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $date = date_add(now(), date_interval_create_from_date_string("7 days"));
        $date = date('Y-m-d', strtotime('+1 week'));
        $events = Event::select('events.id', 'event_name', 'event_description', 'start_date', 'end_date', 'created_by', 'updated_by', 'venue_id',
        'event_type_id', 'organization_id', DB::raw('COUNT(ticket_types.id) AS ticket_type_count'))
                    ->leftJoin('ticket_types', 'ticket_types.event_id', '=', 'events.id')
                    ->leftJoin('venues', 'venues.id', '=', 'events.venue_id')
                    ->where('start_date', '>=', date('Y-m-d'))
                    ->where('start_date', '<=', $date)
                    ->groupBy('events.id', 'event_name', 'event_description', 'start_date', 'end_date', 'created_by', 'updated_by', 'venue_id',
                    'event_type_id', 'organization_id')
                    ->orderBy('start_date')
                    ->get();

        $ticket_types = TicketType::all();

        $ticket_counts = Event::select('events.id', 'event_name','ticket_types.ticket_name', 'ticket_types.ticket_open_date',
                                    'ticket_types.ticket_close_date', 'ticket_types.ticket_cost', 'ticket_types.ticket_limit',
                                    'profile_name',
                                    DB::raw('(ticket_limit - ticket_count) as ticket_left'),
                                    DB::raw('ticket_types.id as ticket_type_id'))
                            ->leftJoin('ticket_types', 'ticket_types.event_id', 'events.id')
                            ->leftJoin(DB::raw("(SELECT ticket_types.id, SUM(quantity) as ticket_count from ticket_types
                                                LEFT JOIN transaction_tickets on transaction_tickets.ticket_type_id = ticket_types.id
                                                GROUP BY ticket_types.id)
                                                AS tc"), 'ticket_types.id', '=', 'tc.id')
                            ->join('patron_profiles', 'patron_profiles.id', '=', 'ticket_types.patron_profile_id')
                            ->orderBy('ticket_types.ticket_name')
                            ->get();

        return view('home', [
            'events' => $events,
            'ticket_types' => $ticket_types,
            'ticket_counts' => $ticket_counts,
        ]);
    }
}
