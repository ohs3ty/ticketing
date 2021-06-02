<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Organization;
use App\Models\User;
use App\Models\OrganizationOrganizer;
use App\Models\Transaction;
use App\Models\TransactionTicket;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) {
        $user_transactions = Transaction::where('user_id', $request->user_id)
                                ->select('transactions.id as transaction_id', 'transaction_total', 'transactions.created_at as transaction_date')
                                ->join('customers', 'customers.id', '=', 'transactions.customer_id')
                                ->orderByDesc('transaction_date')
                                ->get();
                                // ->join('transaction_tickets', 'transactions.id', '=', 'transaction_tickets.transaction_id' )



        return view("user.user_index", [
            'user_transactions' => $user_transactions,
            'user_id' => $request->user_id,
        ]);
    }

    public function transaction_details(Request $request) {
        $error = 0;

        $transaction = Transaction::find($request->transaction_id);

        //what this code is if the event or ticket type is suddenly deleted the order page will still have
        //information from this order, since the html page is saved into the database

        foreach($transaction->transaction_tickets as $detail) {
            //if event or ticket name is not found
            if (!$detail->ticket_type->event) {
                $error = $error + 1;
            }
            if (!$detail->ticket_type) {
                $error = $error + 1;
            }
        }

        if (!$error) {
            //if there is no error, then we want to update the page if there are any changes
            $transaction_html = view("user.transaction_details", [
                'transaction' => $transaction
            ])->render();

            if ($transaction->html != $transaction_html) {
                $transaction->html = $transaction_html;
                $transaction->save();
            }
        }
        return $transaction->html;
    }

}
