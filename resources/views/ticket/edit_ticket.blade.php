@extends('layouts.app')

@section('title')
Add Ticket Type
@endsection

@section('content')

<h2>{{ $ticket_type->event_name }} - {{\Carbon\Carbon::parse($ticket_type->start_date)->format('F j, Y')}}</h2>
<br>
    @if($errors->any())
        <div class="error text-danger"> Please correct the errors below </div>
    @endif
{{Form::open(['url' => '/editticketaction', 'action' => 'post'])}}
<div id="card1" class="card" style="border-color: grey;">
    <div class="card-body">
        <h5 class="card-title">Ticket Type:</h5>
        <div class="container">

            <div class="row no-gutters">
                <div class="card-text col-sm-6">
                    @error('ticket_name')
                        <div class="error text-danger"> {{ $message }} </div>
                    @enderror
                    {{ Form::label('ticket_name', 'Ticket Type Name') }}<br>
                    {{ Form::text('ticket_name', $ticket_type->ticket_name, array('required' => 'required', 'class' => 'card-text', 'size' => 66)) }}
                </div>
                <div class="card-text col-sm-3">
                    @error('ticket_limit')
                        <div class="error text-danger"> {{ $message }} </div>
                    @enderror
                    {{ Form::label('ticket_limit', 'Ticket Quantity') }}<br>
                    {{ Form::number('ticket_limit', null, ['class' => 'w-75']) }}<br>
                    <div class="form-check">
                        @if (is_null($ticket_type->ticket_limit))
                            {{ Form::checkbox('unlimited', 1, null, ['checked' => 'checked', 'class' => 'form-check-input', 'id' => 'unlimited', 'onclick' => 'greyQuantity()'])}}
                        @else
                            {{-- {{ Form::checkbox('unlimited', 1, $ticket_type->$ticket_limit, ['class' => 'form-check-input', 'id' => 'unlimited', 'onclick' => 'greyQuantity()'])}} --}}
                        @endif
                        {{ Form::label('unlimited', 'Unlimited tickets', ['class' => 'form-check-label']) }}
                    </div>
                </div>
                <div class="card-text col-sm-3">
                    {{ Form::label('patron_profile', 'Patron Profile')}}<br>
                    {{ Form::select('patron_profile', array(1 => "General", 2 => "Student", 3 => "BYU Employee"), $ticket_type->patron_profile_id, array('class' => 'custom-select-sm w-75')) }}
                </div>
            </div>
            <br>
            <div class="row no-gutters">
                <div class="card-text col-sm-6">
                    {{ Form::label('ticket_description', 'Ticket Description') }}<br>
                    {{ Form::textarea('ticket_description', $ticket_type->ticket_description, ['class' => 'w-75']) }}
                </div>
                <div class="col-6">
                    <div class="row no-gutters">
                        <div class="card-text col-sm-6">
                            {{ Form::label('ticket_price', 'Ticket Price') }}<br>
                            {{ Form::number('ticket_price', number_format($ticket_type->ticket_cost, 2), ['step' => 0.01, 'class' => 'w-75']) }}<br>
                        </div>
                    </div>
                    <br>
                    <div class="row no-gutters">
                        <div class="card-text col-sm-6">

                            {{ Form::label('ticket_open_date') }}<br>
                            {{ Form::date('ticket_open_date', \Carbon\Carbon::parse($ticket_type->ticket_open_date),
                                ['required' => 'required',  'class' => 'w-75'])}}
                        </div>
                            @error('ticket_close_date')
                                <div class="error text-danger"> {{$message}} </div>
                            @enderror
                        <div class="card-text col-sm-6">
                            {{ Form::label('ticket_close_date') }}<br>
                            {{ Form::date('ticket_close_date', \Carbon\Carbon::parse($ticket_type->ticket_close_date),
                                ['required' => 'required', 'class' => 'w-75'])}}
                        </div>
                    </div>
                    <br><br>
                    <div class="row no-guttters">
                        <div class="card-text col-2"></div>
                        <div class="card-text col-2 text-center">
                            <a class="btn btn-secondary" href="{{ route('viewtickets', ['event_id' => $ticket_type->event_id]) }}">Cancel</a>
                        </div>
                        <div class="card-text col-3 text-center">
                            {{ Form::hidden('ticket_type_id', $ticket_type->id) }}
                            {{ Form::submit('Edit Ticket Group', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Form::hidden('event_id', $ticket_type->event_id)}}
{{Form::close()}}
<script src="/js/script.js"></script>
<!--if the ticket-limit box is checked already-->
<script>
    document.addEventListener("DOMContentLoaded", function(event) {

        if (document.getElementById("unlimited").checked == true) {
            document.getElementById("ticket_limit").disabled = true;
        }
    })
</script>
@endsection
