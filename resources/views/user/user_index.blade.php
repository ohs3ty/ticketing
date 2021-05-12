@extends('layouts.app')

@section('title')
My Tickets and Orders
@endsection

@section('content')

@auth
    @if(Auth::user()->id == $user_id)
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
                            <a href="{{ route('transaction_details', ['transaction_id' => $transaction->transaction_id]) }}">
                                {{ $transaction->transaction_id }}
                            </a>
                        </td>
                        <td>${{ number_format($transaction->transaction_total, 2, ".", ",") }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endauth



@endsection