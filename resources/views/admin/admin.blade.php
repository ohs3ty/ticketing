@extends('layouts.app')

@section('title')
    Admin
@endsection
@section('content')

@if((Auth::user()) and (Auth::user()->role == 'admin'))
    <h3>Organizations</h3>
    <div class="container">
        <a class="btn btn-primary" href="{{ url('/admin/addorganization') }}" style="border-color: lightgrey">Add Organization</a>
    </div>
    <br>
    <div class="container">
        <div class="row">
            @foreach($organizations as $organization)
            <div class="col-4 text-center" style="margin-bottom: 15px; border-color: rgb(179, 179, 179);" >
                <div class="card">
                <div class="card-body">
                    <a href="{{ route('/admin/organization', ['name' => $organization->organization_name]) }}" class="card-title" style="color: black; font-size: large;">{{ $organization->organization_name }}</a>
                </div>
                </div>
            </div>
            @endforeach
        </div>
{{-- List of organizers --}}
        <div class="row">
            @foreach($organizers as $organizer)
            <div class="col-4 text-center" style="margin-bottom: 15px; border-color: rgb(179, 179, 179);" >
                <table class="table">
                    <thead>
                        <tr>
                            <th>Organizer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $organizer->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
@else
    <div class="text-center">
        <h2>You do not have permission to view this page</h2>
    </div>
@endif



@endsection
