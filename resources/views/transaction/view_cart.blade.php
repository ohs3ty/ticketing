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
            <h3>{{ $cart_item->event_name }}</h3>
            {{ $cart_item }}
        @endforeach
    </div>
    <div class="col-4 bg-primary">
    </div>
</div>

@endsection
