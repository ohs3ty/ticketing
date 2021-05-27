@extends('layouts.app')

@section('title')
Transaction Details
@endsection

@section('content')

@auth
    @include('user.partial.transaction_order_detail')
@endauth


@endsection
