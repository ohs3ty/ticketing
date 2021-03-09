@extends('layouts.app')

@section('title')
    Add Organization
@endsection 

@section('content')
    {{ Form::open(array('url' => '/admin/addorganizationaction', 'method' => 'post')) }}

    @error('organization_name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div class="form-group">
        {{ Form::label('organization_name', 'Organization Name')}}<br>
        {{ Form::text('organization_name')}}
    </div>

    @error('cashnet_code')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    <div class="form-group">
        {{ Form::label('cashnet_code', 'Cashnet Code')}}<br>
        {{ Form::text('cashnet_code')}}
    </div>
    <div class="form-group">
        {{ Form::label('organization_website', 'Organization Website')}}<br>
        {{ Form::text('organization_website')}}
    </div>

    <a class="btn btn-secondary" href="{{ url('/admin') }}">Cancel</a>
    {{ Form::submit('Add Organization', ['class' => 'btn btn-primary'])}}
    {{ Form::close()}}

@endsection