@extends('layouts.app')
{{-- only those logged in will view this page --}}
@section('event-header')
    active
@endsection

@section('title')
Edit Event
@endsection

@section('content')

    <div class="container">

        @if($errors->any())
        <div class="alert alert-danger">
            Please correct the errors below<br>
        </div>
        @endif

        @error('delete_err')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror


        {{-- {{Auth::user()->id}} --}}
        {{ Form::open(array('url' => 'event/updateevent', 'method' => 'POST')) }}

        <h3>Edit Event Details</h3>
        @error('event_name')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror
        <div class="form-group">
            {{ Form::label('event_name', 'Event Name')}}<br>
            {{ Form::text('event_name', $event->event_name, ['class' => "form-control"]) }}
        </div>

        @error('end_date')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror

        @error('end_date')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror
        <div class="form-group">
            {{ Form::label('start_date', 'Event Start Date')}}<br>
            <div class="row">
                <div class="col-8">
                    {{ Form::date('start_date', $event->formatDate($event->start_date, 'date_notext'), ['class' => 'form-control']) }}
                </div>
                <div class="col-4">
                    {{ Form::time('start_time', $event->formatDate($event->start_date, 'date_notext'), ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('end_date', 'Event End Date')}}<br>
            <div class="row">
                <div class="col-8">
                    {{ Form::date('end_date', $event->formatDate($event->end_date, 'date_notext'), ['class' => 'form-control']) }}
                </div>
                <div class="col-4">
                    {{ Form::time('end_time', $event->formatDate($event->end_date, 'date_notext'), ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('event_type', 'Event Type')}}<br>
            {{ Form::select('event_type', $event_types, ($event->event_type_id - 1), ['class' => 'form-control'])}}

        </div>
        <div class="form-group">
            {{ Form::label('event_description', 'Event Description')}}<br>
            {{ Form::textarea('event_description', $event->event_description, ['class' => 'form-control']) }}
        </div>

        @error('venue_error')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror

        <div class="form-group">
            <label for="venue">Venue</label><br>
            <input class="form-control" type="text" name="venue" id="venue" autocomplete="off" onkeyup="getVenues({{$venues}})" value="{{$event->venue_name}}">
            <div style="padding-top: 10px; padding-bottom: 10px;" id='venue_lookup'></div>
            {{-- add new venue  --}}
            {{ Form::checkbox('new_venue', 1, null, array('id' => 'new_venue')) }}
            {{ Form::label('new_venue', 'Check if adding a new venue') }}
        </div>
        <div class="form-group" id="add_venue" hidden>
            <div class="row">
                <div class="col-8">
                    {{ Form::label('venue_addr', 'Venue Address') }}<br>
                    {{ Form::text('venue_addr', null, ['class' => 'form-control']) }}<br>
                </div>
                <div class="col-4">
                    {{ Form::label('venue_zipcode', 'Venue Zipcode') }}<br>
                    {{ Form::text('venue_zipcode', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        {{-- organization information --}}
        <hr>
        <h3>Organization Information</h3>
        Choose the organization in charge.<br><br>
        <div class="form-group">
            {{ Form::label('organization_name', 'Organization Name')}}<br>
            {{ Form::select('organization_name', $organization_names, ($event->organization_id), ['class' => 'form-control'])}}

        </div>
        <hr>
        {{-- organizer information --}}
        <h3>Organizer Information</h3>
        Please change your contact information (as the organization contact) as needed:
        <br><br>
        <div class="row">
            <div class="col-6">
                <div class='form-group'>
                    {{ Form::label('organizer_phone', 'Organizer Phone Number') }}<br>
                    {{ Form::text('organizer_phone', $organizer->organizer_phone, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-6">
                <div class='form-group'>
                    {{ Form::label('organizer_email', 'Organizer Email') }}<br>
                    {{ Form::email('organizer_email', $organizer->organizer_email, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <br>
        {{ Form::hidden('user_id', $user_id) }}
        {{ Form::hidden('event_id', $event_id) }}
        <a class="btn btn-secondary" href="{{ route('event.myevents', ['id' => Auth::user()->id]) }}">Cancel</a>
        {{ Form::submit('Update Event', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
        <br>
        {{ Form::open(array('url' => 'event/delete', 'method' => 'post')) }}
        {{ Form::hidden('event_id', $event_id) }}
        {{ Form::hidden('user_id', $user_id) }}

        {{ Form::submit('Delete Event', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this activity?')"]) }}
        {{ Form::close() }}
        <br><br>
    </div>

        <script src="/js/script.js"></script>
@endsection
