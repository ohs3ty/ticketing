@extends('layouts.app')

@section('title')
    Buy Tickets
@endsection

@section('content')

    <div class="row">
        @foreach ( $ticket_types as $ticket_type)
        <div class="col-3">
            @if ((now() > $ticket_type->ticket_close_date) || (now() < $ticket_type->ticket_open_date))
            {{-- if the ticket_close date already passed --}}
            <div class="card mb-3 border-danger" style="max-width: 18rem;">
            @else
            <div class="card mb-3" style="max-width: 18rem;">
            @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket_type->ticket_name }}</h5>
                    <p class="card-text">
                        Ticket Description: <br>@if ($ticket_type->ticket_description == null)
                                                No Description
                                            @else
                                                {{$ticket_type->ticket_description}}
                                            @endif<br>
                        Ticket Cost: ${{$ticket_type->ticket_cost}}<br>
                        @if ((now() > $ticket_type->ticket_close_date) || (now() < $ticket_type->ticket_open_date))
                            <div class="text-danger" style="padding: none;">
                                Sorry, no tickets can be bought at this time
                            </div>
                        @else
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        {{ Form::label('quantity', 'Quantity', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-5">
                                        {{ Form::number('quantity', null, ['min' => 1, 'class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    {{ Form::submit('Buy', ['class' => 'btn btn-primary']) }}
                                </div>
                            {{ Form::close() }}
                        @endif
                    </p>

                    {{ $ticket_type }}

                </div>
            </div>
        </div>
        @endforeach
    </div>



@endsection
