@extends('layouts.app')

@section('title')
    Buy Tickets
@endsection

@section('content')
    <div class="row">
        @foreach ( $ticket_types as $ticket_type)
        <div class="col-3">
            <div class="card mb-3" style="max-width: 18rem;">
                {{-- <div class="card-header"></div> --}}
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket_type->ticket_name }}</h5>
                    <p class="card-text">
                        Ticket Description: {{$ticket_type->ticket_description}} <br>
                        Ticket Cost: ${{$ticket_type->ticket_cost}}<br>
                    </p>
                    {{$ticket_type}}

                </div>
            </div>
        </div>
        @endforeach
    </div>



@endsection
