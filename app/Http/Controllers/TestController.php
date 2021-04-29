<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\TempCart;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_buy(Request $request) {
        $cart_items = TempCart::where('user_id', $request->user_id)
                        ->where('ticket_type_id', $request->ticket_type_id);
        $cart_total = $cart_items
                        ->select(DB::raw('SUM(ticket_quantity * ticket_cost) as transaction_total'))
                        ->join('ticket_types', 'ticket_types.id', '=', 'temp_carts.ticket_type_id')
                        ->get();

        dd($cart_total);
        
        $new_transaction = new Transaction;
        
        
        foreach($cart_items as $item) {
            

        }

        return ("success");
    }
}
