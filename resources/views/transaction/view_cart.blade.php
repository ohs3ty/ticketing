@extends('layouts.app')

@section('title')
View Cart
@endsection

@section('content')

<div class="row">
    <div class="col-8">
        <h2>Your Cart</h2>
        <hr>
        @foreach ($cart_items as $cart_item)
        <div class="row">
            <div class="col-8">
                <h3>{{ $cart_item->event_name }}</h3>
                Ticket Group: {{ $cart_item->ticket_name }}<br>
                Ticket Date: {{ \Carbon\Carbon::parse($cart_item->start_date)->format('l, F j, Y, g:i a') }}
            </div>
            <div class="col-2">
                <div class="input-group mb-3">
                    {{ Form::open(array('url' => 'buy/changequantity', 'method' => 'post')) }}
                    {{ Form::selectRange("ticket_quantity", 1, 100, $cart_item->ticket_quantity,
                        ['class' => 'custom-select']) }}
                    {{ Form::hidden('ticket_type_id', $cart_item->ticket_type_id) }}
                    {{ Form::close() }}
                </div>
            </div>
            <div class="col-2">
                <span style="font-size: 20px;">${{ number_format((floatval($cart_item->ticket_cost) * floatval($cart_item->ticket_quantity)), 2, ".", ",") }}</span>
            </div>
        </div>
        {{ $cart_item }}
        <hr>
        @endforeach
    </div>
    <div class="col-4">
    </div>
</div>

@endsection
