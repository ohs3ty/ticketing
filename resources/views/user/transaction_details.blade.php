@extends('layouts.app')

@section('title')
Transaction Details
@endsection

@section('content')
@include('layouts.partial.cart')
@auth
    <div class="row">
        <div class="col-8">
            <div class="cart_background rounded">
                <div class="row">
                    <div class="col-8">
                        <h2>Order Summary: #{{ $transaction->id }}</h2>
                        <h4>Order Date: {{ \Carbon\Carbon::parse($transaction->created_at)->format('F j, Y, g:i a') }}</h4>
                    </div>
                </div>
                @foreach ($transaction->transaction_tickets as $detail)
                <hr>
                <div class="row">
                    <div class="col-8">
                        <span class="cart-label">ITEM</span>
                        <hr>
                        <h3>{{ $detail->ticket_type->event->event_name }}</h3>
                        Ticket Group: {{ $detail->ticket_type->ticket_name }}<br>
                        Ticket Date: {{ \Carbon\Carbon::parse($detail->ticket_type->event->start_date)->format('l, F j, Y, g:i a') }}<br>
                        Ticket Price: ${{ number_format(floatval($detail->ticket_type->ticket_cost), 2, '.', ',') }}
                    </div>
                    <div class="col-2">
                        <span class="cart-label">QTY</span>
                        <hr>
                        <span style="font-size: 20px;">{{ $detail->quantity }}</span>


                    </div>
                    <div class="col-2">
                        <span class="cart-label">ITEM TOTAL</span>
                        <hr>
                        <span style="font-size: 20px;">${{ number_format($detail->ticket_type->ticket_cost * $detail->quantity, 2, ".", ",") }}</span>
                    </div>
                </div>
                <br>
                <br>
                @endforeach
            </div>
            <br>
            <a href="{{ route('user.index', ['user_id' => Auth()->user()->id]) }}">Back to Order History</a>
        </div>
        <div class="col-4">
            <div class="cart_background rounded">
                <h2>Order Total</h2>
                <hr>
                <div class="row">
                    <div class="col-8">Subtotal</div>
                    <div class="col-4">${{ number_format($transaction->transaction_total, 2, ".", ",") }}</div>
                </div>
                <br>
            </div>
        </div>
    </div>

@endauth


@endsection
