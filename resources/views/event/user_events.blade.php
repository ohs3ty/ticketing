@extends('layouts.app')

@section('title')
My Events
@endsection

@section('content')

@if($user_id != Auth::user()->id)
    <h3>Something went wrong. Please try again.</h3>
@else
<div class="row">
    <div class="col-2">
        <h5>Event Filters:</h5>
            {{ Form::open(array('route' => 'event.myevents', 'method' => 'get')) }}
                {{ Form::hidden('id', Auth()->user()->id) }}
                <div class="filter-box">
                    {{ Form::label('archived', 'Current/Archived')}}<br>
                    {{ Form::select('archived', ['all' => 'all', 'false' => 'current', 'true' => 'archived'], $filters['archived'], ['onchange' => 'this.form.submit()', 'class' => 'form-select']) }}
                </div>
                <div class="filter-box">
                    {{ Form::label('organization', 'Organization')}}<br>
                    {{ Form::select('organization', array_merge(['all' => 'all'], $organizations), $filters['organization'], ['onchange' => 'this.form.submit()']) }}
                </div>
            {{ Form::close() }}
    </div>
    <div class="col-10">
        <div class="row">
            @foreach ($events as $event)
                <div class="col-sm-4" style="padding-bottom: 1.5rem;">
                    <div class="card h-100" style="border-color: rgb(202, 202, 202)">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->event_name}}</h5>
                            <h6 class="card-subtitle text-muted mb-2">{{ $event->organization_name }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y')}}
                                at {{ \Carbon\Carbon::parse($event->start_date)->format('g:i a') }}</h6>
                            <p class="card-text user-card">{{ $event->event_description }}</p>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center no-gutters">
                                <a href="{{ route('event.edit', ['event_id' => $event->id, 'user_id' => Auth::user()->id])}}" class="btn btn-small col-5" style="border-color: lightgrey">View/Edit</a>
                                <span class="col-sm-1"></span>
                                <a href="{{ route('ticket.index', ['event_id' => $event->id]) }}" class="btn btn-small col-5" style="border-color: lightgrey">Tickets</a>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
