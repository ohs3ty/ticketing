@extends('layouts.app')

@section('title')
Add Ticket Type
@endsection

@section('content')

<h2>{{ $event->event_name }} - {{\Carbon\Carbon::parse($event->start_date)->format('F j, Y')}}</h2>
<br>
    @if($errors->any())
        <div class="error text-danger"> Please correct the errors below </div>

        {{ $errors }}
    @endif
{{Form::open(['url' => 'ticket/addticketaction', 'action' => 'post'])}}
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
                    {{ Form::text('ticket_name', null, ['required' => 'required', 'class' => 'w-75 card-text form-control', 'size' => 66]) }}
                </div>
                <div class="card-text col-sm-3">
                    @error('ticket_limit')
                        <div class="error text-danger"> {{ $message }} </div>
                    @enderror
                    {{ Form::label('ticket_limit', 'Ticket Quantity') }}<br>
                    {{ Form::number('ticket_limit', null, ['class' => 'w-75 form-control']) }}
                    <div class="form-check">
                        {{ Form::checkbox('unlimited', 1, null, ['class' => 'form-check-input', 'id' => 'unlimited', 'onclick' => 'greyQuantity()'])}}
                        {{ Form::label('unlimited', 'Unlimited tickets', ['class' => 'form-check-label']) }}
                    </div>
                </div>
                <div class="card-text col-sm-3">
                    {{ Form::label('patron_profile', 'Patron Profile')}}<br>
                    {{ Form::select('patron_profile', array(1 => "General", 2 => "Student", 3 => "BYU Employee"), null, ['class' => 'custom-select-sm w-75 form-control']) }}
                </div>
            </div>
            <br>
            <div class="row no-gutters">
                <div class="card-text col-sm-6">
                    {{ Form::label('ticket_description', 'Ticket Description') }}<br>
                    {{ Form::textarea('ticket_description', null, ['class' => 'w-75 form-control']) }}
                </div>
                <div class="col-6">
                    <div class="row no-gutters">
                        <div class="card-text col-sm-6">
                            {{ Form::label('ticket_price', 'Ticket Price') }}<br>
                            {{ Form::number('ticket_price', null, ['step' => 0.01, 'class' => 'w-75 form-control']) }}<br>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="card-text col-sm-6">

                            {{ Form::label('ticket_open_date') }}<br>
                            {{ Form::date('ticket_open_date', null, ['required' => 'required',  'class' => 'w-75 form-control'])}}
                        </div>
                            @error('ticket_close_date')
                                <div class="error text-danger"> {{$message}} </div>
                            @enderror
                        <div class="card-text col-sm-6">
                            {{ Form::label('ticket_close_date') }}<br>
                            {{ Form::date('ticket_close_date', null, ['required' => 'required', 'class' => 'w-75 form-control'])}}
                        </div>
                    </div>
                    <br><br><br>
                    <div class="row no-guttters">
                        <div class="card-text col-2"></div>
                        <div class="card-text col-2 text-center">
                            <a class="btn btn-secondary" href="{{ route('ticket.index', ['event_id' => $event->id]) }}">Cancel</a>
                        </div>
                        <div class="card-text col-3 text-center">
                            {{ Form::submit('Add Ticket Group', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Form::hidden('event_id', $event->id)}}
{{Form::close()}}
<script src="/js/script.js"></script>
<script>
        document.addEventListener("DOMContentLoaded", function(event) {

            if (document.getElementById("unlimited").checked == true) {
                document.getElementById("ticket_limit").disabled = true;
            }
        })
</script>
@endsection
