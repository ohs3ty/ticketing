@extends('layouts.app')

@section('title')
View Cart
@endsection

@section('content')

<div class="row">
    <div class="col-8 bg-danger">
        <h3>Your Cart</h3>
        <hr>
        @foreach ($cart_items as $cart_item) {
            {{ $cart_item->event_name }}
            {{ $cart_item }}
        }
    </div>
    <div class="col-4 bg-primary">
    </div>
</div>

@endsection
