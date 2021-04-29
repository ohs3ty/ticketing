@extends('layouts.app')

@section('title')
Order Success
@endsection

@section('content')
@include('layouts.partial.cart')

Success Message Here

Go to <a href="{{ route('user_home', ['user_id', Auth::user()->id]) }}">Your Orders</a>

@endsection