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
                <h4>{{ $cart_item->event_name }}</h4>
                Ticket Group: {{ $cart_item->ticket_name }}
            </div>
            <div class="col-2">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                      <option selected>Choose...</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                ${{ number_format((floatval($cart_item->ticket_cost) * floatval($cart_item->ticket_quantity)), 2, ".", ",") }}
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
