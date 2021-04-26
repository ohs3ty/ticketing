@extends('layouts.app')

@section('title')
View Cart
@endsection

@section('content')

<div class="row">
    <div class="col-8 bg-danger">
        <h2>Your Cart</h2>
        <hr>
        @foreach ($cart_items as $cart_item)
        <div class="row">
            <div class="col-8">
                <h4>{{ $cart_item->event_name }}</h4>
                Ticket Group: {{ $cart_item->ticket_name }}
            </div>
            <div class="col-2">
                <select>
                    <option>Hello</option>
                </select>
            </div>
            <div class="col-2">
                ${{ intval($cart_item->ticket_cost) * intval($cart_item->ticket_quantity) }}
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
