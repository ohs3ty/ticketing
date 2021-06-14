@extends('layouts.app')

@section('organization-header')
class='active'
@endsection

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
                <th style="width: 30%;">Description</th>
                <th style="width: 15%;">Location</th>
                <th>Organizer in charge</th>
            </tr>
            @foreach($organization->events as $event)
                @if($event->archived == false)
                    <tr>
                        <td>
                            {{ $event->event_name }}
                        </td>
                        <td>
                            {{ $event->formatDate($event->start_date, 'date_time') }}
                            <br>to<br>
                            {{ $event->formatDate($event->end_date, 'date_time') }}
                        </td>
                        <td>
                            {{ $event->event_description ?? 'No Description' }}
                        </td>
                        <td>
                            {{ $event->venue->venue_name }}
                        </td>
                        <td>
                            {{ $event->organizer->user->name }}
                        </td>
                    </tr>
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
