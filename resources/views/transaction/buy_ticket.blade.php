@extends('layouts.app')

@section('title')
    Buy Tickets
@endsection

@section('content')
    @foreach ( $ticket_types as $ticket_type)
        {{ $ticket_type }} <br>
    @endforeach
@endsection
