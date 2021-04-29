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
                <td></td>
            </tr>
            {{ $transaction }}
        @endforeach
    </tbody>
</table>

@endsection