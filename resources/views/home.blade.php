{{-- packages used: laravelcollective/html, laravel/ui for bootstrap --}}
@extends('layouts.app')
@section('home-header')
class='active'
@endsection

@section('title')
Home
@endsection

@section('content')
<div class="container">
    <h3>This Week's Events</h3>

    @foreach ($events as $event)
        <div class="card" style="border-color: lightgrey">
            <div class="row no-gutters">
                <div class="col-sm-2">
                    <div class="card-body text-right">
                        <h3 style="margin-bottom: 0px;">{{ \Carbon\Carbon::parse($event->start_date)->format('F') }}</h3>
                        <h2 style="margin: none">{{ \Carbon\Carbon::parse($event->start_date)->format('j') }}</h2>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card-body">
                        <h3 class="card-title">{{ $event->event_name }}</h3>
                        <h5 class="card-subtitle text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                            at {{ \Carbon\Carbon::parse($event->start_date)->format('g:i a') }}</h5>
                        <p class="card-text">{{ $event->event_description }}</p>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="text-center" style="padding-top: 25%;">
                        {{-- modal button --}}
                        <button class="btn" data-toggle="modal" data-target="#event{{$event->id}}">View Details</button>
                    </div>
                </div>
                <!-- Modal -->
                    @include('event.event_modal.event_detail')
                {{-- End of modal --}}
            </div>
        </div>
        <br>
    @endforeach
    @guest
        Guest only

    @else

        @if (Auth::user()->role == 'admin')
        {{-- if we want admin powers here --}}
        @else
        {{-- if we want not admin powers but sans guest powers --}}
        @endif
    @endguest
</div>


@endsection
