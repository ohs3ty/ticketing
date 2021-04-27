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

    public function add_ticket_action(Request $request) {

        // Validation
        $validated = $request->validate([
            'ticket_name' => 'bail|required',
            'ticket_close_date' => 'required|date|after:ticket_open_date',
            'ticket_price' => 'required',
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
        $ticket_types = TicketType::select('ticket_types.id', 'ticket_name', 'ticket_cost', 'ticket_description', 'profile_name',
                                            'ticket_open_date', 'ticket_close_date', 'ticket_limit')
                            ->join('patron_profiles', 'patron_profiles.id', '=', 'ticket_types.patron_profile_id')
                            ->join('events', 'events.id', '=', 'ticket_types.event_id')
                            ->where('ticket_types.event_id', '=', $event_id)
                            ->get();

        return view('ticket.view_ticket', [
            'event_id' => $event_id,
            'ticket_types' => $ticket_types,
        ]);
    }

    public function edit_tickets(Request $request) {

        $ticket_type_id = $request->ticket_type_id;
        $ticket_type = TicketType::select('event_name', 'ticket_types.id', 'event_id', 'ticket_name', 'ticket_description',
                                            'ticket_limit', 'patron_profile_id', 'ticket_open_date', 'ticket_close_date', 'ticket_cost',
                                            'start_date')
                                    ->join('events', 'events.id', '=', 'ticket_types.event_id')
                                    ->where('ticket_types.id', $ticket_type_id)
                                    ->first();


                                    // return ($ticket_type);
        return view('ticket.edit_ticket', [
            'ticket_type' => $ticket_type
        ]);

    }
    public function edit_ticket_action(Request $request) {
        $ticket_type_id = $request->ticket_type_id;
        $ticket_type = TicketType::find($ticket_type_id);

        $ticket_type->ticket_name = $request->ticket_name;
        // if ticket cost is empty
        if (is_null($request->ticket_cost)) {
            $ticket_cost = 0.0;
        } else {
            $ticket_cost = $request->ticket_cost;
        }
        $ticket_type->ticket_cost = $ticket_cost;
        $ticket_type->ticket_description = $request->ticket_description;
        $ticket_type->patron_profile_id = $request->patron_profile;
        $ticket_type->ticket_open_date = $request->ticket_open_date;
        $ticket_type->ticket_close_date = $request->ticket_close_date;

        if ($request->unlimited == 0) {
            $ticket_limit = $request->ticket_limit;

            // if ticket limit is empty but is not checked, redirect
            if (empty($ticket_limit)) {
                return back()
                    ->withInput()
                    ->withErrors(['ticket_limit' => 'Required']);
            }
        }
        $ticket_type->ticket_limit = $request->ticket_limit;
        $ticket_type->save();

        return redirect()->route('viewtickets', ['event_id' => $ticket_type->event_id]);
    }

    public function delete_ticket(Request $request) {
        $ticket_type = TicketType::find($request->ticket_type_id)->first();
        $event_id = $ticket_type->event_id;
        TicketType::find($request->ticket_type_id)->delete();
        $cart_items = TempCart::where('ticket_type_id', $request->ticket_type_id)
                        ->get();
        foreach($cart_items as $item) {
            TempCart::where('id', $item->id)->first()->delete();
        }
        return redirect()->route('viewtickets', ['event_id' => $event_id]);
    }
}
