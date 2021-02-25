<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\TicketType;

class TicketController extends Controller
{
    //
    public function add_ticket(Request $request) {
        $event = Event::find($request->event_id);

        return view('ticket.add_ticket', [
            'event' => $event,
        ]);
    }

    public function addticketaction(Request $request) {

        // Validation
        $validated = $request->validate([
            'ticket_name' => 'bail|required',
            'ticket_close_date' => 'required|date|after:ticket_open_date',
        ]);
        
        $event_id = $request->event_id;
        $ticket_name = $request->ticket_name;
        $unlimited_bool = $request->unlimited;
        $patron_profile_id = $request->patron_profile;
        $ticket_description = $request->ticket_description;
        $ticket_cost =  $request->ticket_price;
        $ticket_open_date = date("Y-m-d H:i:s", strtotime("{$request->ticket_open_date}"));

        // $ticket_close_date = $request->ticket_close_date;
        $ticket_close_date = date("Y-m-d H:i:s", strtotime("{$request->ticket_close_date}"));


        $new_ticket = new TicketType;
        $new_ticket->event_id = $event_id;
        $new_ticket->ticket_name = $ticket_name;
        $new_ticket->patron_profile_id = $patron_profile_id;
        $new_ticket->ticket_description = $ticket_description;
        $new_ticket->ticket_cost = $ticket_cost;
        $new_ticket->ticket_open_date = $ticket_open_date;
        $new_ticket->ticket_close_date = $ticket_close_date;


        
        if ($unlimited_bool == 0) {
            $ticket_limit = $request->ticket_limit;
        
            // if ticket limit is empty but is not checked, redirect 
            if (empty($ticket_limit)) {
                return back()
                    ->withInput()
                    ->withErrors(['ticket_limit' => 'Required']);
            }

            $new_ticket->ticket_limit = $ticket_limit;
        } 

        $new_ticket->save();

        return redirect()->route('viewtickets', ['event_id' => $event_id]);
    }

    public function view_tickets(Request $request) {
        $event_id = $request->event_id;

        $ticket_types = TicketType::where('event_id', $event_id)
                            ->join('patron_profiles', 'patron_profiles.id', '=', 'ticket_types.patron_profile_id')
                            ->get();

        return view('ticket.view_ticket', [
            'event_id' => $event_id,
            'ticket_types' => $ticket_types,
        ]);
    }

    public function edit_tickets(Request $request) {

        $ticket_type_id = $request->ticket_type_id;

        $ticket_type = TicketType::select('ticket_types.id', 'ticket_name', 'ticket_cost', 'ticket_limit', 'ticket_description', 
                                            'event_id', 'patron_profile_id', 'ticket_open_date', 'ticket_close_date',
                                            'event_name')
                                    ->join('events', 'events.id', '=', 'ticket_types.event_id')
                                    ->first();
        
        return view('ticket.edit_ticket', [
            'ticket_type' => $ticket_type
        ]);
    }
}
