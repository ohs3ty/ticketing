@extends('layouts.app')

@section('title')
Transaction Details
@endsection

@section('content')

<h4>Order Summary for Order #{{ $transaction_id }}</h4>
{{$transaction_details}}
<div class="row">
    <div class="col-8">
        <div class="cart_background rounded">
            @foreach ($transaction_details as $detail)
            <hr>
            <div class="row">
                <div class="col-8">
                    <span class="cart-label">ITEM</span>
                    <hr>
                    <h3>{{ $detail->event_name }}</h3>
                    Ticket Group: {{ $detail->ticket_name }}<br>
                    Ticket Date: {{ \Carbon\Carbon::parse($detail->start_date)->format('l, F j, Y, g:i a') }}<br>
                    Ticket Price: ${{ number_format(floatval($detail->ticket_cost), 2, '.', ',') }}
                </div>
                <div class="col-2">
                    <span class="cart-label">QTY</span>
                    <hr>
                    
                </div>
                <div class="col-2">
                    <span class="cart-label">ITEM TOTAL</span>
                    <hr>
                    <span style="font-size: 20px;">$</span>
                </div>
            </div>
            <br>
            <br>
            @endforeach
        </div>
        <br><br><br>
        Back to Order History
    </div>
    <div class="col-4">
        <div class="cart_background rounded">
            <h2>Order Total</h2>
            <hr>
            <div class="row">
                <div class="col-8">Subtotal</div>
                <div class="col-4">$</div>
            </div>
            <br>
        </div>
    </div>
</div>

@endsection