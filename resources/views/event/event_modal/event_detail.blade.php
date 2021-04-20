<div id="event{{$event->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <div class="text-left">
                <h3>{{ $event->event_name }}</h3>
                <h5 class="modal-subtitle">Starts on {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y, g:i a') }}</h5>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <h5>Event Time:</h5>
                <p>
                    {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y, g:i a') }} to {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y, g:i a') }}
                </p>
            <h5>About This Event:</h5>
                <p>
                    {{ $event->event_description }}
                </p>
            <h5>Tickets</h5>
            @if($ticket_type_count > 0)

            @else
                <p>No tickets are currently available</p>
            @endif

            {{ $event }}
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
