<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Organization;
use App\Models\User;
use App\Models\OrganizationOrganizer;
use App\Models\Transaction;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) {
        dd($request->user_id);
        $user_transactions = Transaction::where('customer_id', '=', $request->user_id)
                                ->join('transaction_tickets', 'transactions.id', '=', 'transaction_tickets.transaction_id' )
                                ->get();
        return view("user.user_index", [
            'user_transactions' => $user_transactions,
        ]);
    }


}