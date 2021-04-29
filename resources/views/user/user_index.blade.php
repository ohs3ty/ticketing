@extends('layouts.app')

@section('title')
My Tickets and Orders
@endsection

@section('content')
<h3>Past Orders</h3>

{{ $user_transactions }}

@foreach($user_transactions as $transaction)
    {{ $transaction }}
@endforeach

@endsection