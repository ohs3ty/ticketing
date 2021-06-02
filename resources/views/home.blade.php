{{-- packages used: laravelcollective/html, laravel/ui for bootstrap --}}
@extends('layouts.app')
@section('home-header')
class='active'
@endsection

@section('title')
Home
@endsection

@section('content')
@include('layouts.partial.cart')

<div class="container">
    <h3>This Week's Events</h3>
    <br>
    @foreach ($events as $event)
        <div class="card" style="border-color: lightgrey">
            <div class="row no-gutters">
                <div class="col-sm-2">
                    <div class="card-body text-right">
                        <h3 style="margin-bottom: 0px;">{{ $event->formatDate($event->start_date, 'month') }}</h3>
                        <h2 style="margin: none">{{ $event->formatDate($event->start_date, 'day_num') }}</h2>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="card-body">
                        <h3 class="card-title">{{ $event->event_name }}</h3>
                        <h5 class="card-subtitle text-muted">{{ $event->formatDate($event->start_date, 'date') }}
                            at {{ $event->formatDate($event->start_date, 'time') }}</h5>
                        <p class="card-text index-card">{{ $event->event_description }}</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="text-center">
                        {{-- modal button --}}
                        <button class="btn border-secondary" style="margin-top: 25%; margin-bottom: 25%;" data-toggle="modal" data-target="#event{{$event->id}}">View Details/Buy Tickets</button>
                    </div>
                </div>
                <!-- Modal -->
                    @include('event.event_modal.event_detail')
                {{-- End of modal --}}
            </div>
        </div>
        <br>
    @endforeach

    {{-- test role-based authentication here (probably could be commented out)--}}
    @guest

    @else

        @if (Auth::user()->role == 'admin')
        {{-- if we want admin powers here --}}
        @else
        {{-- if we want not admin powers but sans guest powers --}}
        @endif
    @endguest
</div>


@endsection
