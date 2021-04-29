<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\TempCart;
use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_buy(Request $request) {
        $cart_items = TempCart::where('user_id', $request->user_id)
                        ->where('ticket_type_id', $request->ticket_type_id);
        $cart_total = ($cart_items
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
                $user = User::where('user_id', $request->user_id)->first();
                $new_customer = new Customer;
                $new_customer->cust_firstname = $user->preferredFirstName;
                $new_customer->cust_lastname = $user->preferredLastName;
                $new_customer->cust_email = $user->email;
                $new_customer->save();
                $customer = Customer::where('user_id', $request->user_id)->first();
            }
            dd($customer);
        }

        $new_transaction = new Transaction;
        $new_transaction->transaction_total = $cart_total;
        $new_transaction->transaction_date = date("Y/m/d h:i:s");
        
        
        dd($new_transaction);
        foreach($cart_items as $item) {
            

        }

        return ("success");
    }
}
