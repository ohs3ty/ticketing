<div id="event{{$event->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <div class="text-left">
                <h3>{{ $event->event_name }}</h3>
                <h4 class="modal-subtitle">Starts on {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y, g:i a') }}</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Event Time:</h4>
                <p>
                    {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y, g:i a') }} to {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y, g:i a') }}
                </p>
            <h4>About This Event:</h4>
                <p>
                    {{ $event->event_description }}
                </p>
            <h4>Tickets</h4>
            <hr>
            @if($event->ticket_type_count > 0)
                @foreach ($ticket_counts as $ticket_count)
                    @if($ticket_count->id == $event->id)
                    <div class="row">
                        <div class="col-4">
                            <h5>{{ $ticket_count->ticket_name }}</h5>
                            <h5>${{ number_format($ticket_count->ticket_cost, 2, '.', ',') }}</h5>
                        </div>
                    </div>

                        {{ $ticket_count }}
                    <hr>

                    @endif
                @endforeach
            @else
                <p>No tickets are currently available</p>
            @endif
            {{ $event }}

            ticket


            Ticket Groups:<br>
            <div class="container">
                @if($event->ticket_type_count > 0)
                    @foreach ($ticket_types as $ticket_type)
                        @if($ticket_type->event_id == $event->id)
                            {{ $ticket_type->ticket_name }}<br>
                            <div class="container">
                                Ticket sales for this group starts on {{\Carbon\Carbon::parse($ticket_type->ticket_open_date)->format('F j, Y')}}
                                and closes on (ticket close date)<br>
                                @foreach ($ticket_counts as $ticket_count)

                                    @if(($ticket_count->id == $event->id) && ($ticket_count->ticket_name == $ticket_type->ticket_name))
                                    Number of Tickets Left:

                                        @if ($ticket_count->ticket_limit == null)
                                            Unlimited
                                        @else
                                            {{ $ticket_count->ticket_limit }}
                                        @endif

                                    @endif

                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    No Tickets Available
                @endif

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            {{-- buy tickets button --}}
            @if ($event->ticket_type_count > 0)

                <a class="btn btn-default" href="{{ route('buy_ticket', ['event_id' => $event->id]) }}">Buy Tickets</a>
            @endif
        </div>
    </div>

    </div>
</div>
