@extends('layouts.app')

@section('organization-header')
class='active'
@endsection

@section('title')
{{ $organization->organization_name }}
@endsection

@section('content')

<h4 class="text-center organization_title">UPCOMING EVENTS</h4>
<div class="container">
    <div class="row table-responsive">
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
</div>

<h4 class="text-center organization_title">ORGANIZATION DETAILS&nbsp;
    @auth
        @if(Auth::user()->hasRole('admin'))
            <a style="color: rgb(70, 71, 95); cursor: pointer;" onclick="editDetails('detail')">
                <i id="detail_pencil" class="bi bi-pencil-fill"></i>
            </a>
        @endif
    @endauth
</h4>
<div class="container">
    {{ Form::open(array('route' => 'organization.edit-organization', 'method' => 'post')) }}
        <div class="row">
            <div class="col-lg-3 col-sm-6" style="padding-bottom: 10px;">
                <h5>WEBSITE</h5>
                <span name="organization_edit">{{ $organization->organization_website }}</span>
                {{ Form::text('website_input', $organization->organization_website, ['id' => 'website_input', 'class' => 'form-control', 'hidden', 'required']) }}
            </div>
            <div class="col-lg-2 col-sm-6">
                <h5>CASHNET CODE</h5>
                <span name="organization_edit">{{ $organization->cashnet_code }}</span>
                {{ Form::text('cashnet_input', $organization->cashnet_code, ['id' => 'cashnet_input', 'class' => 'form-control', 'hidden', 'required']) }}
            </div>
            <div class="col-lg-2">
                <br>
                {{ Form::hidden('organization_id', $organization->id) }}
                @auth
                    @if (Auth::user()->hasRole('admin'))
                        {{ Form::submit('save', ['class' => 'btn btn-primary', 'id' => 'detail_button', 'style' => 'margin-top: 5px;', 'hidden']) }}
                        <a onclick="editDetails('cancel_detail')" hidden id="detail_cancel" class="btn btn-secondary" style="margin-top: 5px;">cancel</a>
                    @endif
                @endauth
            </div>
        </div>
    {{ Form::close() }}
</div>

<h4 class="text-center organization_title">CONTACT INFORMATION&nbsp;
</h4>
    <div class="container">
        <h5>ORGANIZERS</h5>
        <div class="row">
            @foreach ($organizers as $organizer)
                <div class="col-lg-3 col-sm-12">
                    <div style="border: 1px solid #7c8dad; border-radius: 7px; padding: 20px; margin: 5px;">
                        <strong>{{ $organizer->user->name }}</strong><br>
                        {{ $organizer->organizer_email }}<br>
                        {{ $organizer->format_phone }}<br>
                        @auth
                            @if(Auth::user()->hasRole('admin'))
                                {{-- {{ Form::delete(route('organization.delete-organizer', [$organization->id, $organizer->id]), 'delete') }} --}}
                                <a href="{{ route('organization.delete-organizer', [$organization->id, $organizer->id]) }}" style="margin-top: 3px;" class="btn btn-danger btn-sm">delete</a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach

            @auth
                @if(Auth::user()->hasRole('admin'))
                    @if(count($dropdown_organizers) > 0)
                    <div hidden id='add_organizer_div' class="col-lg-3 col-sm-12">
                    {{ Form::open(array('route' => 'organization.edit-organization', 'method' => 'post')) }}

                        {{ Form::select('organizer_id', $dropdown_organizers, null, ['class' => 'form-control', 'style' => 'margin-top: 5px;']) }}
                        {{ Form::hidden('organization_id', $organization->id) }}
                        {{ Form::hidden('add_detail', 'add_organizer') }}
                        <br>
                        {{ Form::submit('add', ['class' => 'btn btn-primary']) }}
                        <a onclick="addOrganizer('cancel')" class="btn btn-secondary">cancel</a>
                    {{ Form::close() }}
                    </div>
                    <div id='add_organizer_button' class="col-lg-3 col-sm-12">
                        <i onclick="addOrganizer('add')" style="font-size: 30px; color: #7c8dad; margin: 5px; cursor: pointer;" class="bi bi-plus-circle"></i>
                    </div>
                    @endif
                @endif
            @endauth

        </div>
    </div>
    <script src="/js/script.js"></script>

@endsection
