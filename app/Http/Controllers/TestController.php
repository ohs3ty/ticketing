<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\TempCart;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\User;
use App\Models\TransactionTicket;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_buy(Request $request) {
        $cart_items = TempCart::where('user_id', $request->user_id)
                        ->get();
        $cart_total = (TempCart::where('user_id', $request->user_id)
                        ->select(DB::raw('SUM(ticket_quantity * ticket_cost) as transaction_total'))
                        ->join('ticket_types', 'ticket_types.id', '=', 'temp_carts.ticket_type_id')
                        ->first())->transaction_total;

        date_default_timezone_set("America/Denver");
        //see if customer with user_id exists
        //if session_id exists, create a new customer
        if ($request->user_id != null) {
            $customer = Customer::where('user_id', $request->user_id)->first();
            if ($customer) {
                //pass
            } else {
                $user = User::where('id', $request->user_id)->first();
                $new_customer = new Customer;
                $new_customer->cust_firstname = $user->preferredFirstName;
                $new_customer->cust_lastname = $user->preferredSurname;
                $new_customer->cust_email = $user->email;
                $new_customer->user_id = $user->id;
                $new_customer->save();

                $customer = Customer::where('user_id', $request->user_id)->first();
            }
        }

        $transaction_id = substr(hash('sha256', time()), 0, 5) . substr(hash('sha256', $request->user_id), 0, 5);
        $new_transaction = new Transaction;
        $new_transaction->id = $transaction_id;
        $new_transaction->transaction_total = $cart_total;
        $new_transaction->customer_id = $customer->id;
        $new_transaction->status = "pending";
        $new_transaction->save();

        foreach($cart_items as $item) {
            $new_transactionticket = new TransactionTicket;
            $new_transactionticket->quantity = $item->ticket_quantity;
            $new_transactionticket->transaction_id = $transaction_id;
            $new_transactionticket->ticket_type_id = $item->ticket_type_id;
            $new_transactionticket->save();
            TempCart::find($item->id)->delete();
        }

        return view('transaction.order_success');
    }
}
