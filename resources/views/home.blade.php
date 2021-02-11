{{-- packages used: laravelcollective/html, laravel/ui for bootstrap --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Home</h4>
    @guest
    Guest only
    
    @else
    
    @if (Auth::user()->role == 'admin')
    Admin powers!
    @else
    No powers
    @endif
    @endguest
</div>


@endsection
