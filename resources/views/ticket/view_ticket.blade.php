@extends('layouts.app')

@section('title')
View Ticket
@endsection

@section('content')

<h2>Ticket Groups</h2>
<br>

@if( $ticket_groups->isEmpty()) 
    No ticket groups made yet.
@endif

@foreach ($ticket_groups as $ticket_group)
<div class="card">
    <div class="card-header">
        <h4>Ticket Name: {{$ticket_group->ticket_name}}</h4>
    </div>
    <div class="card-body">
        <div class="row no-gutters">
            <span class="text-muted col-3">Ticket Cost</span>
        </div>
        <div class="row no-gutters">
            <span class="col-3">${{ number_format($ticket_group->ticket_cost, 2) }}</span>
        </div>
    </div>
</div>
<br>
<a>Add Ticket Group</a>
@endforeach
@endsection