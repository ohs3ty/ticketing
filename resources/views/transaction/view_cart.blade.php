@extends('layouts.app')

@section('title')
View Cart
@endsection

@section('content')

<div class="row">
    <div class="col-8 bg-danger">
        <h3>Your Cart</h3>
        <hr>
        {{ $cart_items->ticket_name }}
        {{ $cart_items }}
    </div>
    <div class="col-4 bg-primary">
    </div>
</div>

@endsection
