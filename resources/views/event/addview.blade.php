@extends('layouts.app')
{{-- only those logged in will view this page --}}
@section('content')

    @if($user_id != Auth::user()->id)
        <h3>Something went wrong. Please try again.</h3>
    @else
        {{-- if admin or creator --}}
        @if ((Auth::user()->role == 'admin') || (Auth::user()->role == 'organizer'))
            <div class="container">
                {{-- {{Auth::user()->id}} --}}
                {{ Form::open(array('url' => '/addeventaction', 'method' => 'POST')) }}

                <h3>Event Information</h3>
                <br>
                @error('event_name')
                    <div class="error"> {{ $message }} </div>
                @enderror
                <div class="form-group">
                    {{ Form::label('event_name', 'Event Name')}}<br>
                    {{ Form::text('event_name')}}
                </div>

                @error('end_date')
                    <div class="error"> {{ $message }} </div>
                @enderror

                @error('end_date')
                    <div class="error"> {{ $message }} </div>
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
                
                {{-- organization information --}}
                <h3>Organization Information</h3>
                <br>
                <div class='form-group'>
                    {{ Form::label('organization_name', 'Organization Name') }}<br>
                    {{ Form::text('organization_name') }}
                {{-- quasi search function, if not in then it will add the new organization to the database --}}
                </div>
                <div class='form-group'>   
                    {{ Form::label('cashnet_code', 'Cashnet Code') }}<br>
                    {{ Form::text('cashnet_code') }}
                </div>
                <div class='form-group'>
                    {{ Form::label('organization_website', 'Organization Email') }}<br>
                    {{ Form::email('organization_website') }}
                </div>
                {{-- organizer information --}}
                <br>
                <h3>Organizer Information</h3>
                Please change your contact information (as the organization contact) as needed:
                <br><br>
                <div class='form-group'>
                    {{ Form::label('organizer_phone', 'Organizer Phone Number') }}<br>
                    {{ Form::text('organizer_phone') }}
                </div>    
                <div class='form-group'>
                    {{ Form::label('organizer_email', 'Organizer Email') }}<br>
                    {{ Form::email('organizer_email') }}
                </div>
                <br>

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
