<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTimes;
use App\Models\TicketType;
use App\Models\TempCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use DateInterval;
use DateTime;

class TransactionController extends Controller {

    public function buy_ticket_action(Request $request) {
        //if the ticket_quantity is null, validate and send user back
        $msg = '';
        if ($request->ticket_quantity == null) {
            $msg = 'Ticket groups for this event is not currently selling.';
        }

        if ($msg) {
            return Redirect::back()->withErrors(['general' => $msg]);
        }

        //get event and ticket object
        $event = TicketType::where('event_id', $request->event_id)
                ->get();

        foreach ($request->ticket_quantity as $ticket_group) {
            print(key($ticket_group));
            print($ticket_group[key($ticket_group)]);
            $cart = new TempCart;
            $cart->ticket_type_id = key($ticket_group);
            $cart->ticket_quantity = $ticket_group[key($ticket_group)];
            $cart->event_id = $request->event_id;
            $cart->user_id = $request->user_id;

            $cart->save();

        }
        dd($request->ticket_quantity);

        //if the user is logged in, we'll send in the user_id
        //otherwise we send in the current session id
        //create a new temp cart object
        //add the data into the temp cart

        //question? if we are using session tokens, then when do we delete that from the database or do we not even add the data with session
        //to the database, we just put it in the session

        //for now only work with the database


        //we also have to take into account if the user isn't logged in and is just using
        //the session to record the cart things to buy things
        //we also have to take into account whether the user is authorized to purchase a certain group of tickets

        return ('success');
    }




}
