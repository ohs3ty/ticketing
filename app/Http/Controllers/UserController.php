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
        $user_transactions = Transaction::where('user_id', $request->user_id)
                                ->select('transaction_id', 'transaction_total', 'transaction_date')
                                ->join('customers', 'customers.id', '=', 'transactions.customer_id')
                                ->get();
                                // ->join('transaction_tickets', 'transactions.id', '=', 'transaction_tickets.transaction_id' )
        return view("user.user_index", [
            'user_transactions' => $user_transactions,
        ]);
    }


}