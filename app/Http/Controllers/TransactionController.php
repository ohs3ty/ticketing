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

        //if the user is logged in, we'll send in the user_id
        //otherwise we send in the current session id

        //create a new temp cart object
        //add the data into the temp cart
        foreach ($request->ticket_quantity as $ticket_group) {
            //see if the specific ticket group and event already exists in the cart (because then we'll just update the cart)
            if ($ticket_group[key($ticket_group)] > 0) {
                $current_carts = TempCart::where('user_id', $request->user_id)
                                ->where('event_id', $request->event_id)
                                ->where('ticket_type_id', key($ticket_group))
                                ->get();

                if (count($current_carts) > 0) {
                    foreach ($current_carts as $current_cart) {
                        $cart = TempCart::find($current_cart->id);
                        $cart->ticket_quantity = intval($ticket_group[key($ticket_group)]);
                    }
                }
                else {
                    $cart = new TempCart;
                    $cart->ticket_type_id = key($ticket_group);
                    $cart->ticket_quantity = $ticket_group[key($ticket_group)];
                    $cart->event_id = $request->event_id;
                    $cart->user_id = $request->user_id;
                }

                $cart->save();

            }
        }
        //question? if we are using session tokens, then when do we delete that from the database or do we not even add the data with session
        //to the database, we just put it in the session

        //for now only work with the database


        //we also have to take into account if the user isn't logged in and is just using
        //the session to record the cart things to buy things
        //we also have to take into account whether the user is authorized to purchase a certain group of tickets
        $cart_items = TempCart::where('user_id', $request->user_id)
                    ->get();

        return redirect()->route('mycart', ['user_id' => $request->user_id]);

    }

    public function view_cart(Request $request) {
        $cart_items = TempCart::where('user_id', $request->user_id)
                        ->join('ticket_types', 'ticket_types.id', '=', 'temp_carts.ticket_type_id')
                        ->join('events', 'events.id', '=', 'temp_carts.event_id')
                        ->leftJoin(DB::raw("(SELECT ticket_types.id, count(transaction_tickets.id) as ticket_count from ticket_types
                                                LEFT JOIN transaction_tickets on transaction_tickets.ticket_type_id = ticket_types.id
                                                GROUP BY ticket_types.id)
                                                AS tc"), 'ticket_types.id', '=', 'tc.id')
                        ->get();

        return view('transaction.view_cart', [
            'cart_items' => $cart_items,
        ]);
    }

    public function change_ticket_quantity(Request $request) {

        $cart = TempCart::where('user_id', $request->user_id)
                ->where('ticket_type_id', $request->ticket_type_id)
                ->first();

        return redirect()->route('mycart', ['user_id' => $request->user_id]);
    }




}
