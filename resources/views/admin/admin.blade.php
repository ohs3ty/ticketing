@extends('layouts.app')

@section('title')
    Admin
@endsection

@section('admin-header')
    class="active"
@endsection

@section('content')

@if((Auth::user()) and (Auth::user()->role == 'admin'))
    <h3>Organizations</h3>
    <div class="container">
        <a class="btn btn-primary" href="{{ url('admin/addorganization') }}" style="border-color: lightgrey">Add Organization</a>
    </div>
    <br>
    <div class="container">
        <div class="row">
            @foreach($organizations as $organization)
            <div class="col-4 text-center" style="margin-bottom: 15px; border-color: rgb(179, 179, 179);" >
                <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.organization', ['name' => $organization->organization_name]) }}" class="card-title" style="color: black; font-size: large;">{{ $organization->organization_name }}</a>
                </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
{{-- List of organizers --}}

    <br><br>

    <h3>Organizers</h3>
    <div class="container">
        <div class="row">
            <div class="col-4 text-center" style="margin-bottom: 15px; border-color: rgb(179, 179, 179);" >
                <table class="table">
                    <thead>
                        <tr>
                            <th>Organizer</th>
                            <th>List of Organizations</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organizers as $organizer)

                            <tr class="text-left">
                                <td>{{ $organizer->name }}</td>
                                <td>
                                    @foreach ($organization_organizers as $o_o )
                                        @if($organizer->id == $o_o->organizer_id)
                                            {{ $o_o->organization_name }}<br>
                                        @endif
                                    @endforeach
                                </td>
                                <td><th><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteOrganizer{{ $organizer->id }}"><i class="bi-trash-fill"></i></button></th></td>
                                @include("admin.modal.delete_organizer")
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="text-center">
        <h2>You do not have permission to view this page</h2>
    </div>
@endif



@endsection
