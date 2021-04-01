@extends('layouts.app')
{{-- only those logged in will view this page --}}
@section('title')
View All Events
@endsection

@section('content')
    <h3>This Year's Events</h3>
    <br>
    {{-- Loops through each month and all events in that month --}}
    @for($i = 0; $i < 12; $i++)
        <section>
        @foreach ($events as $event)
            @if (\Carbon\Carbon::parse($event->start_date)->format('n') == ($i + 1))
                <div class="card" style="border-color: lightgrey">
                    <div class="row no-gutters">
                        <div class="col-sm-2">
                            <div class="card-body text-right">
                                <h3 style="margin-bottom: 0px;">{{ $months[$i]}}</h3>
                                <h2 style="margin: none">{{ \Carbon\Carbon::parse($event->start_date)->format('j') }}</h2>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="card-body">
                                <h3 class="card-title">{{ $event->event_name }}</h3>
                                <h5 class="card-subtitle text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                                    at {{ \Carbon\Carbon::parse($event->start_date)->format('g:i a') }}</h5>
                                <p style="margin-top: 5px;" class="card-text">{{ $event->event_description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endif
        @endforeach
            </section>
    @endfor

@endsection
