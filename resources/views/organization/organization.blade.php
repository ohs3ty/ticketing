@extends('layouts.app')

@section('organization-header')
class='active'
@endsection

@section('title')
Organizations
@endsection

@section('content')
    <h4>Organizations</h4>
    <br>
    <div class="row">
        @foreach($organizations as $organization)
            <div class="col-lg-3 col-sm-6">
                <div class="organization_card card" onclick="location.href='{{ route('organization.organization-detail', ['organization_id' => $organization->id]) }}'">
                    <div class="card-body text-center" style="font-size: large;">
                        {{ $organization->organization_name }}
                    </div>
                </div>
            </div>
        @endforeach
        @auth
            @if(Auth::user()->hasRole('admin'))
                <div class="col-lg-3 col-sm-6">
                    <i style="margin: 5px;" data-toggle="modal" data-target="#add_organization" class="add-icon bi bi-plus-circle"></i>
                </div>
            @endif
        @endauth

        @include('organization.modal.add_organization')
    </div>


@endsection
