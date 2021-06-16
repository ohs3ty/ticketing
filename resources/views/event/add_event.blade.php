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
        @if (Auth::user()->hasRole('admin') or Auth::user()->hasRole('organizer'))
            <div class="container">

                @if($errors->any())
                    <div class="error text-danger">Please correct the errors below<br></div>
                @endif

                {{-- {{Auth::user()->id}} --}}
                {{ Form::open(array('url' => 'event/addeventaction', 'method' => 'post')) }}

                <h3>Event Information</h3>
                @error('event_name')
                    <div class="error text-danger"> {{ $message }} </div>
                @enderror
                <div class="form-group">
                    {{ Form::label('event_name', 'Event Name')}}<br>
                    {{ Form::text('event_name', null, ['class' => "form-control"]) }}
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
                            {{ Form::date('start_date', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                        </div>
                        <div class="col-4">
                            {{ Form::time('start_time', \Carbon\Carbon::createFromFormat('H:i:s', '00:00:00'), ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('end_date', 'Event End Date')}}<br>
                    <div class="row">
                            <div class="col-8">
                                {{ Form::date('end_date', \Carbon\Carbon::now(), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-4">
                                {{ Form::time('end_time', \Carbon\Carbon::createFromFormat('H:i:s', '00:00:00'), ['class' => 'form-control']) }}
                            </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('event_type', 'Event Type')}}<br>
                    {{ Form::select('event_type', $event_types, null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('event_description', 'Event Description')}}<br>
                    {{ Form::textarea('event_description', null, ['placeholder' => 'Write a brief description', 'class' => 'form-control']) }}
                </div>

                @error('venue_error')
                    <div class="error text-danger"> {{ $message }} </div>
                @enderror

                <div class="form-group">
                    <label for="venue">Venue</label><br>
                    <input class="form-control" type="text" name="venue" id="venue" autocomplete="off" onkeyup="getVenues({{$venues}})">
                    <div style="padding-top: 10px; padding-bottom: 10px;" id='venue_lookup'></div>
                    {{-- add new venue  --}}
                    {{ Form::checkbox('new_venue', 1, null, ['id' => 'new_venue']) }}
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
                <hr>
                {{-- organization information --}}
                <h3>Organization Information</h3>
                Choose the organization in charge.<br><br>

                <div class="form-group">
                    {{ Form::label('organization_name', 'Organization Name')}}<br>
                    {{ Form::select('organization_name', $organization_names, null, ['class' => 'form-control']) }}
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
                {{Form::hidden('user_id', $user_id)}}
                <a class="btn btn-danger" href="{{ url('event') }}">Cancel</a>
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
