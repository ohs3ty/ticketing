@extends('layouts.app')
{{-- only those logged in will view this page --}}

@section('title')
Add Event
@endsection

@section('event-header')
    active
@endsection
@section('content')

    @if($user_id != Auth::user()->id)
        <h3>Something went wrong. Please try again.</h3>
    @else
        @if ((Auth::user()->role == 'admin') || (Auth::user()->role == 'organizer'))
            <div class="container">

                @if($errors->any())
                <div class="error text-danger"> Please correct the errors below </div>
                @endif

                
                {{-- {{Auth::user()->id}} --}}
                {{ Form::open(array('url' => '/addeventaction', 'method' => 'POST')) }}

                <h3>Event Information</h3>
                @error('event_name')
                    <div class="error text-danger"> {{ $message }} </div>
                @enderror
                <div class="form-group">
                    {{ Form::label('event_name', 'Event Name')}}<br>
                    {{ Form::text('event_name')}}
                </div>

                @error('end_date')
                    <div class="error text-danger"> {{ $message }} </div>
                @enderror

                @error('end_date')
                    <div class="error text-danger"> {{ $message }} </div>
                @enderror
                <div class="form-group">
                    {{ Form::label('start_date', 'Event Start Date')}}<br>
                    {{ Form::date('start_date', \Carbon\Carbon::now()) }}
                    {{ Form::time('start_time', \Carbon\Carbon::createFromFormat('H:i:s', '00:00:00')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('end_date', 'Event End Date')}}<br>
                    {{ Form::date('end_date', \Carbon\Carbon::now()) }}
                    {{ Form::time('end_time', \Carbon\Carbon::createFromFormat('H:i:s', '00:00:00')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('event_type', 'Event Type')}}<br>
                    {{ Form::select('event_type', $event_types) }}
                </div>
                <div class="form-group">
                    {{ Form::label('event_description', 'Event Description')}}<br>
                    {{ Form::textarea('event_description'), array('placeholder' => 'Write a brief description') }}
                </div>

                @error('venue_error')
                    <div class="error text-danger"> {{ $message }} </div>
                @enderror

                <div class="form-group">
                    <label for="venue">Venue</label><br>
                    <input type="text" name="venue" id="venue" autocomplete="off" onkeyup="getVenues({{$venues}})">
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
                    {{ Form::select('organization_name', $organization_names)}}
                    {{-- {{ Form::select('size', array('L' => 'Large'), 'S') }} --}}
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
                {{Form::hidden('user_id', $user_id)}}
                <a class="btn btn-danger" href="{{ url('events') }}">Cancel</a>
                {{ Form::submit('Add Event', array('class' => 'btn btn-secondary')) }}
                {{ Form::close() }}
                <br><br>
            </div>
        
    @else
        {{-- if general or nonadmin --}}

        <div class="container">
            <h3 class='text-center'>Sorry, you don't have permission to add an event.</h3>
            <h5 class='text-center'>Contact your department to gain access.</h5>
        </div>
    @endif    
    @endif
        
        <script src="/js/script.js"></script>
@endsection
