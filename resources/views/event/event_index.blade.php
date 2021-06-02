@extends('layouts.app')
{{-- only those logged in will view this page --}}
@section('title')
View All Events
@endsection

@section('content')
@include('layouts.partial.cart')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <h3>Upcoming Events</h3>
    <br>
    {{-- Loops through each month and all events in that month --}}
    {{-- if we want to add a header month for each month or something --}}


    @for($i = 0; $i < 12; $i++)
        <section>
        @foreach ($events as $event)
            @if (\Carbon\Carbon::parse($event->start_date)->format('n') == ($i + 1))
                <div class="card" style="border-color: lightgrey">
                    <div class="row no-gutters">
                        <div class="col-sm-2">
                            <div class="card-body text-right">
                                <h3 style="margin-bottom: 0px;">{{ $months[$i]}}</h3>
                                <h2 style="margin: none">{{ $event->formatDate($event->start_date, 'day_num') }}</h2>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h3 class="card-title">{{ $event->event_name }}</h3>
                                <h5 class="card-subtitle text-muted">{{ $event->formatDate($event->start_date, 'date') }}
                                    at {{ $event->formatDate($event->start_date, 'time') }}</h5>
                                <p style="margin-top: 10px;" class="card-text">{{ $event->event_description }}</p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div style="height: 35%;">

                            </div>
                            <div class="text-center index-card">
                                {{-- modal button --}}
                                <button class="btn border-secondary" data-toggle="modal" data-target="#event{{$event->id}}">View Details/Buy Tickets</button>
                            </div>
                        </div>
                        <!-- Modal -->
                            @include('event.event_modal.event_detail')
                        {{-- End of modal --}}
                    </div>
                </div>
                <br>
            @endif
        @endforeach
            </section>
    @endfor
@endsection
