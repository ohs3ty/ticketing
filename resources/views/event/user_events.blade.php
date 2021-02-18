@extends('layouts.app')

@section('content')

@if($user_id != Auth::user()->id)
    <h3>Something went wrong. Please try again.</h3>
@else
    {{ $events }}
@endif

@endsection