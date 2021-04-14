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
        <div class="error text-danger"> Please correct the errors below </div>
        @endif


        {{-- {{Auth::user()->id}} --}}
        {{ Form::open(array('url' => '/updateevent', 'method' => 'POST')) }}

        <h3>Edit Event Details</h3>
        @error('event_name')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror
        <div class="form-group">
            {{ Form::label('event_name', 'Event Name')}}<br>
            {{ Form::text('event_name', $event->event_name)}}
        </div>

        @error('end_date')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror

        @error('end_date')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror
        <div class="form-group">
            {{ Form::label('start_date', 'Event Start Date')}}<br>
            {{ Form::date('start_date', \Carbon\Carbon::parse($event->start_date)) }}
            {{ Form::time('start_time', \Carbon\Carbon::parse($event->start_date)) }}
        </div>
        <div class="form-group">
            {{ Form::label('end_date', 'Event End Date')}}<br>
            {{ Form::date('end_date', \Carbon\Carbon::parse($event->end_date)) }}
            {{ Form::time('end_time', \Carbon\Carbon::parse($event->end_date)) }}
        </div>
        <div class="form-group">
            {{ Form::label('event_type', 'Event Type')}}<br>
            {{ Form::select('event_type', $event_types, ($event->event_type_id - 1))}}

        </div>
        <div class="form-group">
            {{ Form::label('event_description', 'Event Description')}}<br>
            {{ Form::textarea('event_description', $event->event_description) }}
        </div>

        @error('venue_error')
            <div class="error text-danger"> {{ $message }} </div>
        @enderror

        <div class="form-group">
            <label for="venue">Venue</label><br>
            <input type="text" name="venue" id="venue" autocomplete="off" onkeyup="getVenues({{$venues}})" value="{{$event->venue_name}}">
            <div style="padding-top: 10px; padding-bottom: 10px;" id='venue_lookup'></div>
            {{-- add new venue  --}}
            {{ Form::checkbox('new_venue', 1, null, array('id' => 'new_venue')) }}
            {{ Form::label('new_venue', 'Check if adding a new venue') }}
        </div>
        <div class="form-group" id="add_venue" hidden>
            {{ Form::label('venue_addr', 'Venue Address') }}<br>
            {{ Form::text('venue_addr') }}<br>
            {{ Form::label('venue_zipcode', 'Venue Zipcode') }}<br>
            {{ Form::text('venue_zipcode') }}
        </div>

        {{-- organization information --}}
        <h3>Organization Information</h3>
        Choose the organization in charge.<br><br>
        <div class="form-group">
            {{ Form::label('organization_name', 'Organization Name')}}<br>
            {{ Form::select('organization_name', $organization_names, ($event->organization_id - 1))}}

        </div>

        {{-- organizer information --}}
        <h3>Organizer Information</h3>
        Please change your contact information (as the organization contact) as needed:
        <br><br>
        <div class='form-group'>
            {{ Form::label('organizer_phone', 'Organizer Phone Number') }}<br>
            {{ Form::text('organizer_phone', $organizer->organizer_phone) }}
        </div>
        <div class='form-group'>
            {{ Form::label('organizer_email', 'Organizer Email') }}<br>
            {{ Form::email('organizer_email', $organizer->organizer_email) }}
        </div>
        <br>
        {{ Form::hidden('user_id', $user_id) }}
        {{ Form::hidden('event_id', $event_id) }}
        <a class="btn btn-secondary" href="{{ route('myevents', ['id' => Auth::user()->id]) }}">Cancel</a>
        {{ Form::submit('Update Event', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
        <br>
        {{ Form::open(array('url' => 'delete', 'method' => 'post')) }}
        {{ Form::hidden('event_id', $event_id) }}
        {{ Form::hidden('user_id', $user_id) }}

        {{ Form::submit('Delete Event', array('class' => 'btn btn-danger')) }}
        {{ Form::close() }}
        <br><br>
    </div>

        <script src="/js/script.js"></script>
@endsection
