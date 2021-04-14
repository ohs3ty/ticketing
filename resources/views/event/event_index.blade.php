@extends('layouts.app')
{{-- only those logged in will view this page --}}
@section('title')
View All Events
@endsection

@section('content')
    <h3>This Year's Events</h3>
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
                                <h2 style="margin: none">{{ \Carbon\Carbon::parse($event->start_date)->format('j') }}</h2>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h3 class="card-title">{{ $event->event_name }}</h3>
                                <h5 class="card-subtitle text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                                    at {{ \Carbon\Carbon::parse($event->start_date)->format('g:i a') }}</h5>
                                <p style="margin-top: 10px;" class="card-text">{{ $event->event_description }}</p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-center" style="padding-top: 25%;">
                                {{-- modal button --}}
                                <button class="btn" data-toggle="modal" data-target="#event{{$event->event_id}}">View Details</button>
                            </div>
                        </div>
                        <!-- Modal -->
                            <div id="event{{$event->event_id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                    <p>Some text in the modal.</p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                                </div>
                            </div>
                        {{-- End of modal --}}
                    </div>
                </div>
                <br>
            @endif
        @endforeach
            </section>
    @endfor
@endsection
