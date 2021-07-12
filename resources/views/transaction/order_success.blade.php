@extends('layouts.app')

@section('title')
Order Success
@endsection

@section('content')

Success Message Here<br>

Go to <a href="{{ route('user.index', ['user_id' => Auth::user()->id]) }}">Your Orders</a>

@endsection
