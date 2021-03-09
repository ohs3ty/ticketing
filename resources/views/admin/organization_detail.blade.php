@extends('layouts.app')

@section('title')
{{ $organization->organization_name }}
@endsection

@section('content')
<h2> {{ $organization->organization_name }} 
<button type="button" class="btn" data-toggle="modal" data-target="#editOrganization"><i class="bi-pencil-fill" style="font-size: 1rem;"></i></button>
</h2>
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

    {{-- errors --}}
    @if ($errors->any())
        <div class="text-center alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </ul>
        </div>
    @endif

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
                    <th><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteOrganizer{{ $organizer->id }}"><i class="bi-trash-fill"></i></button></th>
                    @include("admin.modal.delete_confirm")

                    <th>{{ $organizer->last_name }}, {{ $organizer->first_name }}</th>
                    <th>{{ $organizer->organizer_email }}</th>
                    <th>{{ $organizer->organizer_phone }}</th>
                    <th>{{ $organizer->email }}</th>
                    <th><button type="button" class="btn" data-toggle="modal" data-target="#editOrganizer{{$organizer->id}}"><i class="bi-pencil-fill" style="font-size: 1rem;"></i></button></th>

                    @include("admin.modal.edit_organizer")
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn" style="border-color: lightgrey;" data-toggle="modal" data-target="#addOrganizer">Add Organizer</button>

    @include("admin.modal.add_organizer")
    @include("admin.modal.edit_organization")
        

  </div>
</div>
@endsection