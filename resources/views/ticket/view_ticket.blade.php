@extends('layouts.app')

@section('title')
View Ticket
@endsection

@section('content')

<h2>Ticket Types</h2>
<a class="btn" style="border-color: lightgrey;" href="{{ route('myevents', ['id' => Auth::user()->id]) }}">Back</a>
<br><br>
@if( $ticket_types->isEmpty())
    No ticket groups made yet.
@endif
{{-- display the ticket types --}}
<div class="row">
@foreach ($ticket_types as $ticket_type)
<div class="card col-5 m-4">
    <div class="card-header">
        <h4 style="padding-top: 10px">{{$ticket_type->ticket_name}}</h4>
    </div>
    <div class="card-body">
        <div class="row no-gutters">
            <span class="text-muted col-4">Ticket Description</span>
        </div>
        <div class="row no-gutters">
            <span class="col-12">
                @if (empty($ticket_type->ticket_description))
                    <span class="font-italic">No Description</span><br><br>
                @else
                    {{ $ticket_type->ticket_description }}<br><br>
                @endif
            </span>
        </div>

        <div class="row no-gutters">
            <span class="text-muted col-4">Ticket Cost</span>
            <span class="text-muted col-4">Ticket Quantity</span>
            <span class="text-muted col-4">Patron Profile</span>
        </div>

        <div class="row no-gutters">
            <span class="col-4">${{ number_format($ticket_type->ticket_cost, 2) }}</span>
            <span class="col-4">
                @if (empty($ticket_type->ticket_limit))
                Unlimited
                @else
                {{ $ticket_type->ticket_limit }}
                @endif
            </span>
            <span class="col-4">{{ $ticket_type->profile_name }}</span>
        </div>
        <br>
        <div class="row no-gutters">
            <span class="col-4 text-muted">Ticket Open Date</span>
            <span class="col-4 text-muted">Ticket Close Date</span>
        </div>

        <div class="row no-gutters">
            <span class="col-4">{{ \Carbon\Carbon::parse($ticket_type->ticket_open_date)->format('F j, Y')}}</span>
            <span class="col-4">{{ \Carbon\Carbon::parse($ticket_type->ticket_close_date)->format('F j, Y')}}</span>
        </div>
        <br>
        <a class="btn" style="border-color: lightgrey;" href="{{ route('edittickets', ['ticket_type_id' => $ticket_type->id]) }}")>Edit</a>
    </div>
</div>
<br>
@endforeach
</div>
<br><br>
<a class="btn btn-secondary" href="{{ route('ticket-add', ['event_id' => $event_id]) }}">Add Ticket Type</a><br><br>
@endsection
