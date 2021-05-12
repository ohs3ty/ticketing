{{ Form::open(['route' => 'buy_ticket', 'method' => 'post']) }}
    <div id="event{{$event->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-left" style="padding: 10px;">
                    <h2>{{ $event->event_name }}</h2>
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
                        @if ($event->event_description == null)
                            <span style="font-style: italic;">No Description</span>
                        @else
                            {{ $event->event_description }}
                        @endif
                    </p>
                <h4>Venue</h4>
                    <p> {{$event->venue_name}}</p>
                <h4>Tickets</h4>
                <hr>
                @if($event->ticket_type_count > 0)
                    @foreach ($ticket_counts as $ticket_count)
                        @if(($ticket_count->id == $event->id))
                        {{-- if past or before sale date range --}}
                            <div class="row container" style="padding: 10px">
                                <div class="col-8"> 
                                    <h5>{{ $ticket_count->ticket_name }}</h5>
                                    <h5>${{ number_format($ticket_count->ticket_cost, 2, '.', ',') }}</h5>
                                    {{ $ticket_count->profile_name }}
                                    {{ Auth::user()->patron_profile}}
                                </div>

                                <div class="col-4">
                                    <h5>Ticket Quantity</h5>
                                    @if((now() >= $ticket_count->ticket_open_date) && (now() <= $ticket_count->ticket_close_date))
                                        @if ($ticket_count->ticket_left == null)
                                            {{ Form::selectRange("ticket_quantity[][$ticket_count->ticket_type_id]", 0, 100, null, ['class' => 'form-select', 'aria-label' => 'Default select example']) }}
                                        @elseif ($ticket_count->ticket_left == 0) 
                                            <span class="text-danger">No more tickets available for this group</span>
                                        @else
                                            {{ Form::selectRange("ticket_quantity[][$ticket_count->ticket_type_id]", 0, $ticket_count->ticket_left, null, ['class' => 'form-select', 'aria-label' => 'Default select example']) }}
                                        @endif
                                    @else
                                        <span class="text-danger">Tickets not currently selling for this group</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
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
                    {{ Form::hidden('event_id', $event->id) }}
                    @if(Auth::check())
                        {{ Form::hidden('user_id', Auth::user()->id) }}
                    @else
                        {{ Form::hidden('session_id', Session::getId()) }}
                    @endif

                    {{ Form::submit('Add to Cart', ['class' => 'btn']) }}
                @endif

            </div>
        </div>

        </div>
    </div>
{{ Form::close() }}
