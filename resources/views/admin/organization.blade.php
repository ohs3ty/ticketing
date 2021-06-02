@extends('layouts.app')

@section('title')
Organizations
@endsection

@section('content')
    @auth
        @if(Auth()->user()->role == "admin")
        <h4>Organizations</h4>
        <br>
        <div class="row">
            @foreach($organizations as $organization)
                <div class="col-3">
                    <div class="organization_card card" onclick="location.href='{{ route('admin.organization-detail', ['organization_id' => $organization->id]) }}'">
                        <div class="card-body text-center" style="font-size: large;">
                                {{ $organization->organization_name }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    @endauth

@endsection
