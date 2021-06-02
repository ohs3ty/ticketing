@extends('layouts.app')

@section('title')
{{ $organization->organization_name }}
@endsection

@section('content')

<h4 class="text-center organization_title">UPCOMING EVENTS</h4>
    <div class="row">
        <table class="table">
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th style="width: 40%;">Description</th>
                <th>Organizer in charge</th>
            </tr>
            @foreach($organization->events as $event)
                @if($event->archived == false)
                {{-- {{ Form::open() }} --}}
                    <tr>
                        <td>
                            <button class="btn" onclick="admin_edit_event({{$event->id}})"><i class="bi bi-pencil-fill"></i></button>
                            <span name="event{{$event->id}}">{{ $event->event_name }}</span>
                            {{ Form::text('event_name', $event->event_name, ['class' => 'form-control', 'hidden', 'id' => "name_input$event->id"]) }}

                        </td>
                        <td>
                            <span name="event{{$event->id}}">{{ $event->formatDate($event->start_date, 'date_time') }}<br>
                            to<br>
                            {{ $event->formatDate($event->end_date, 'date_time') }}</td></span>
                        <td>
                            @if($event->event_description)
                                {{ $event->event_description}}
                            @else
                                <span style="font-style: italic">No Description</span>
                            @endif
                        </td>
                        <td>
                            {{ $event->organizer->user->name }}&nbsp;&nbsp;
                        </td>
                    </tr>
                {{-- {{ Form::close() }} --}}
                @endif
            @endforeach
        </table>
    </div>

<h4 class="text-center organization_title">ORGANIZATION DETAILS</h4>
<div class="container">
    <div class="row">
        <div class="col-3">
            <h5>WEBSITE</h5>
            {{ $organization->organization_website }}
        </div>
        <div class="col-3">
            <h5>CASHNET CODE</h5>
            {{ $organization->cashnet_code }}
        </div>
        </div>
</div>

<h4 class="text-center organization_title">CONTACT INFORMATION</h4>
    <div class="container">
        <h5>ORGANIZERS</h5>
        <div class="row">
            @foreach ($organizers as $organizer)
                <div class="col-3">
                    <strong>{{ $organizer->user->name }}</strong><br>
                    {{ $organizer->organizer_email }}<br>
                    {{ $organizer->format_phone }}
                </div>
            @endforeach
        </div>
    </div>
    <script src="/js/script.js"></script>

@endsection
