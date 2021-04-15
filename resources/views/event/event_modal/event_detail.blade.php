<div id="event{{$event->event_id}}" class="modal fade" role="dialog">
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
                @foreach ($ticket_types as $ticket_type)
                @if($ticket_type->event_id == $event->id)
                    {{ $ticket_type->ticket_name }}<br>
                    <div class="container">
                        Number of Tickets Left:
                    </div>
                @endif
            @endforeach
            </div>

        </div>
        <a type="button">Buy Tickets</a>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

    </div>
</div>
