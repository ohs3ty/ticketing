<div id="event{{$event->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <div class="text-left">
                <h4>Details for {{ $event->event_name }}</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            Start: {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y g:i a') }}<br>
            End: {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y g:i a') }}<br>
            Description: {{ $event->event_description }}<br>
            Ticket Cost: ${{ $event->ticket_cost }}<br>
            Ticket Groups:<br>
            <div class="container">
                @if($event->ticket_type_count > 0)
                    @foreach ($ticket_types as $ticket_type)
                        @if($ticket_type->event_id == $event->id)
                            {{ $ticket_type->ticket_name }}<br>
                            <div class="container">
                                @foreach ($ticket_counts as $ticket_count)
                                    @if($ticket_count->id == $event->id)
                                        hello
                                    @endif
                                @endforeach
                                Number of Tickets Left:
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

    {{ $ticket_counts }}

    </div>
</div>
