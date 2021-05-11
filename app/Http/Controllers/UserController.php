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

        $transaction_details = TransactionTicket::all()
                                ->join('ticket_types', 'ticket_types.id', '=', 'transaction_tickets.ticket_type_id')
                                ->get();
        return view("user.user_index", [
            'user_transactions' => $user_transactions,
            'transaction_details' => $transaction_details,
        ]);
    }


}