<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTimes;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use DateInterval;
use DateTime;

class TransactionController extends Controller {

    public function buy_ticket_action(Request $request) {
        $msg = '';
        if ($request->ticket_quantity == null) {
            $msg = 'Ticket groups for this event is not currently selling.';
        }

        if ($msg) {
            return Redirect::back()->withErrors(['general' => $msg]);
        }

        print(count($request->ticket_quantity));
        foreach ($request->ticket_quantity as $i) {
                print($i);
        }
        dd($request->ticket_quantity);

        //if the ticket_quantity is null, validate and send user back
        // get the id of the ticket_name
        // create new customer object if not a user; if a user, create a customer object based off user? Not sure
        // create a new transaction object (with cart in status)
        // add transaction and ticket id to the linking table
        // transfer that data to the view
        // good luck, shayna

        //we also have to take into account if the user isn't logged in and is just using
        //the session to record the cart things to buy things
        //we also have to take into account whether the user is authorized to purchase a certain group of tickets

        return ('success');
    }




}
