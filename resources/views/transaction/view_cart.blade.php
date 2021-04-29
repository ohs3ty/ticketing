@extends('layouts.app')

@section('title')
View Cart
@endsection

@section('content')
@include('layouts.partial.cart')
<br>
<div class="row">
    <div class="col-8">
        <div class="cart_background rounded">
            <h2>Your Cart ({{ $cart_total->num_items }} items)</h2>
            @foreach ($cart_items as $cart_item)
            <hr>
            <div class="row">
                <div class="col-8">
                    <span class="cart-label">ITEM</span>
                    <hr>
                    <h3>{{ $cart_item->event_name }}</h3>
                    Ticket Group: {{ $cart_item->ticket_name }}<br>
                    Ticket Date: {{ \Carbon\Carbon::parse($cart_item->start_date)->format('l, F j, Y, g:i a') }}<br>
                    Ticket Price: ${{ number_format(floatval($cart_item->ticket_cost), 2, '.', ',') }}
                </div>
                <div class="col-2">
                    <span class="cart-label">QTY</span>
                    <hr>
                    <div class="input-group mb-3">
                        {{ Form::open(array('url' => 'buy/changequantity', 'method' => 'post')) }}
                        {{ Form::selectRange("ticket_quantity", 1, 100, $cart_item->ticket_quantity,
                            ['class' => 'custom-select', 'onchange' => 'this.form.submit()']) }}
                        {{ Form::hidden('ticket_type_id', $cart_item->ticket_type_id) }}
                        {{ Form::hidden('session_id', Session::getId()) }}
                        {{ Form::hidden('user_id', $cart_item->user_id) }}
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="col-2">
                    <span class="cart-label">ITEM TOTAL</span>
                    <hr>
                    <span style="font-size: 20px;">${{ number_format((floatval($cart_item->ticket_cost) * floatval($cart_item->ticket_quantity)), 2, ".", ",") }}</span>
                </div>
            </div>
            {{-- delete --}}
            <br>
            <a style="color: black;" href="{{ route('delete_cart_item', ['cart_item_id' => $cart_item->id]) }}">REMOVE</a>
            <br>
            <br>
            @endforeach
        </div>
    </div>
    <div class="col-4">
        <div class="cart_background rounded">
            <h2>Total</h2>
            <hr>
            <div class="row">
                <div class="col-8">Subtotal</div>
                <div class="col-4">${{ number_format($cart_total->ticket_total, 2, ".", ",") }}</div>
            </div>
            <br>
        </div>
        <br>
        @if (count($cart_items) > 0) 
            
            @if (Auth::user())
                <a href="{{ route('buy_cashnet', ['user_id' => Auth::user()->id]) }}" style="width: 100%;" class="btn btn-primary" type="button">Pay Now</a>
            @else
                <a href="{{ route('buy_cashnet', ['session_id' => Session::getId()]) }}" style="width: 100%;" class="btn btn-primary" type="button">Pay Now</a>
            @endif
        @endif
    </div>
</div>

<br><br>

    {{-- for testing --}}
    @if (Auth::user())
        @if(count($cart_items) > 0)
            <a href="{{ route('test_buy', ['user_id' => Auth::user()->id]) }}" class="btn btn-primary">Skip to Buy</a>
        @endif
    @endif
@endsection
