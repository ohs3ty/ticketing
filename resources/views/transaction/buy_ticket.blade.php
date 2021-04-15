@extends('layouts.app')

@section('title')
    Buy Tickets
@endsection

@section('content')
    @foreach ( $ticket_types as $ticket_type)
    <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
        <div class="card-header">Header</div>
        <div class="card-body">
            <h5 class="card-title">Primary card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
    </div>
        {{ $ticket_type->ticket_name }} <br>
    @endforeach
@endsection
