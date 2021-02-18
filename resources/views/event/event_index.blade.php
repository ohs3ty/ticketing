@extends('layouts.app')
{{-- only those logged in will view this page --}}

@section('content')
    <h3>This Year's Events</h3>
    <br>
    {{-- Loops through each month and all events in that month --}}
    @for($i = 0; $i < 12; $i++)
        <h4>{{ $months[$i] }}</h4>

        @foreach ($events as $event)
            @if (\Carbon\Carbon::parse($event->start_date)->format('n') == ($i + 1))
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $event->event_name }}</h2>
                        <h4 class="card-subtitle text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} 
                            at {{ \Carbon\Carbon::parse($event->start_date)->format('g:i a') }}</h4>
                        <p class="card-text">{{ $event->event_description }}</p>
                    </div>
                </div>
                <br>
            @endif
        @endforeach
    @endfor
    
@endsection