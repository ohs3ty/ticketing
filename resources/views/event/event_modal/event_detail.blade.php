{{ Form::open(['route' => 'buy.buy_ticket', 'method' => 'post']) }}
    <div id="event{{$event->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-left" style="padding: 10px; padding-bottom: 0px;">
                    <h2>{{ $event->event_name }}</h2>
                    <h4 class="modal-subtitle">starts on {{ $event->formatDate($event->start_date, 'date_time') }}</h4>
                    <h5 class="modal-subtitle">by
                    <a class="modal-subtitle" href="{{ route('organization.organization-detail', ['organization_id' => $event->organization->id]) }}">{{ $event->organization->organization_name }}</a></h5>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-center event_title">ABOUT THIS EVENT</div>
                            <p>
                                @if ($event->event_description == null)
                                    <span style="font-style: italic;">No Description</span>
                                @else
                                    {{ $event->event_description }}
                                @endif
                            </p>
                            <br>
                        </div>
                        <div class="col-5">
                            <div class="text-center event_title">EVENT TIME</div>
                                <p>
                                    {{ $event->formatDate($event->start_date, 'date_time') }}<br>
                                    to<br>
                                    {{ $event->formatDate($event->start_date, 'date_time') }}
                                </p>
                            <br>
                            <div class="text-center event_title">VENUE</div>
                            <p>
                                {{ $event->venue->venue_name }}<br>
                                <span>{{ $event->venue->venue_addr }}</span><br>
                                {{ $event->venue->venue_zipcode }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center event_title">TICKETS</div>
                    @if($event->ticket_type_count > 0)
                        @foreach ($ticket_counts as $ticket_count)
                            @if(($ticket_count->id == $event->id))
                            {{-- if past or before sale date range --}}
                                @if (($ticket_count->profile_name == 'General') || (Auth::user() && (Auth::user()->patron_profile == $ticket_count->profile_name)))
                                    <div class="row container" style="padding: 10px">
                                        <div class="col-7">
                                            <h5>{{ $ticket_count->ticket_name }}</h5>
                                            <h5>${{ number_format($ticket_count->ticket_cost, 2, '.', ',') }}</h5>
                                            {{ $ticket_count->profile_name }}
                                            {{-- {{ Auth::user()->patron_profile}} --}}
                                        </div>

                                        <div class="col-4" style="margin-left: 15px;">
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
                            @endif
                        @endforeach
                    @else
                        <p class="text-danger">No tickets are currently available</p>
                        <hr>
                    @endif
                    <div class="text-center event_title">ORGANIZATION CONTACT</div>
                    {{ $event->organizer->user->name }}<br>
                    {{ $event->organizer->organizer_email }}<br>
                    {{ $event->organizer->format_phone }}
                </div>
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
