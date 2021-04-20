<div id="event{{$event->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <div class="text-left">
                <h3>{{ $event->event_name }}</h3>
                <h4 class="modal-subtitle">Starts on {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y, g:i a') }}</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <h4>Event Time:</h4>
                <p>
                    {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y, g:i a') }} to {{ \Carbon\Carbon::parse($event->end_date)->format('l, F j, Y, g:i a') }}
                </p>
            <h4>About This Event:</h4>
                <p>
                    {{ $event->event_description }}
                </p>
            <h4>Tickets</h4>
            <hr>
            @if($event->ticket_type_count > 0)
                @foreach ($ticket_counts as $ticket_count)
                    @if(($ticket_count->id == $event->id))
                        <div class="row container modal-border" style="padding: 5px">
                            <div class="col-8">
                                <h5>{{ $ticket_count->ticket_name }}</h5>
                                <h5>${{ number_format($ticket_count->ticket_cost, 2, '.', ',') }}</h5>
                            </div>
                            <div class="col-4">
                                <h5>Ticket Quantity</h5>
                                @if ($ticket_count->ticket_left == null)
                                    {{ Form::selectRange('number', 0, 100, null, ['class' => 'form-select', 'aria-label' => 'Default select example']) }}
                                @else
                                    {{ Form::selectRange('number', 0, $ticket_count->ticket_left, null, ['class' => 'form-select', 'aria-label' => 'Default select example']) }}
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-danger">No tickets are currently available</p>
                <hr>
            @endif
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
