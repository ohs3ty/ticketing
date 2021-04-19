@extends('layouts.app')

@section('title')
    Buy Tickets
@endsection

@section('content')
    <div class="row">
        @foreach ( $ticket_types as $ticket_type)
        <div class="col-3 bg-primary">
            <div class="card mb-3" style="max-width: 18rem;">
                {{-- <div class="card-header"></div> --}}
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket_type->ticket_name }}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>



@endsection
