@extends('layouts.app')

@section('title')
My Tickets and Orders
@endsection

@section('content')
<h3>Past Orders</h3>


<table>
    <thead>
        <tr>
            <th>Date Purchased</th>
            <th>Transaction Number</th>
            <th>Transaction Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user_transactions as $transaction)
            <tr>
                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date, "F j, Y g:i a") }}</td>
                <td>{{ $transaction->transaction_id }}</td>
                <td>${{ number_format($transaction->transaction_total, 2, ".", ",") }}</td>
            </tr>
            {{ $transaction }}
        @endforeach
    </tbody>
</table>

@endsection