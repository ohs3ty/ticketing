@extends('layouts.app')

@section('title')
{{ $organization->organization_name }}
@endsection

@section('content')
<h2> {{ $organization->organization_name }} </h2>
<br>

<div class="row" style="font-size: medium;">
    <div class="col-2" style="font-weight: bold;">
        Cashnet Code: 
    </div>
    <div class="col-2">
        {{ $organization->cashnet_code }}
    </div>
</div>

<div class="row" style="font-size: medium;">
    <div class="col-2" style="font-weight: bold;">
        Organization Website: 
    </div>
    <div class="col-2">
        {{ $organization->organization_website }}
    </div>
</div>
<br><br>
<h3>Organizers</h3>

@if (count($organizers) == 0) 
    <div class="container">
        No organizers assigned
    </div>
    <br>

@else
    <table class="table">
        <thead>
            <th></th>
            <th scope="col">Name</th>
            <th scope="col">Organizer Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Personal Email</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($organizers as $organizer)
                <tr>
                    <th><a href=""><i class="bi-trash-fill text-danger" style="font-size: 1rem;"></i></a></th>
                    <th>{{ $organizer->last_name }}, {{ $organizer->first_name }}</th>
                    <th>{{ $organizer->organizer_email }}</th>
                    <th>{{ $organizer->organizer_phone }}</th>
                    <th>{{ $organizer->email }}</th>
                    <th><a onclick=""><i class="bi-pencil-fill" style="font-size: 1rem;"></i></a></th>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    @endif
    
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn" style="border-color: lightgrey;" data-toggle="modal" data-target="#addOrganizer">Add Organizer</button>

    @include("admin.modal.add_organizer")


  </div>
</div>
@endsection