<?php

namespace App\Http\Controllers;
use App\Models\TempCart;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_buy(Request $request) {
        $cart_items = TempCart::where('user_id', $request->user_id)
                        ->where('ticket_type_id', $request->ticket_type_id);
        $cart_total = $cart_items->get();

        dd($cart_total);
        
        $new_transaction = new Transaction;
        
        
        foreach($cart_items as $item) {
            

        }

        return ("success");
    }
}
