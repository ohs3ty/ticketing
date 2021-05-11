@extends('layouts.app')

@section('title')
My Tickets and Orders
@endsection

@section('content')
<h3>Past Orders</h3>


<table class="table">
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
                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format("F j, Y g:i a") }}</td>
                {{-- modal --}}
                <td>    
                    <button class="btn" data-toggle="modal" data-target="#myModal">{{ $transaction->transaction_id }}</button>
                </td>
                <td>${{ number_format($transaction->transaction_total, 2, ".", ",") }}</td>
                
            </tr>
            <!-- Modal -->
            @include('transaction.transaction_modal.transaction_detail')
            {{-- End of modal --}}
        @endforeach
    </tbody>
</table>

@endsection