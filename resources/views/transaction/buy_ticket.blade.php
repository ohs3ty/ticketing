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
                        <div class="row bg-primary">
                            <div class="col-auto">
                                {{ Form::label('quantity', 'Quantity', ['class' => 'col-form-label']) }}
                            </div>
                            <div class="col-2">
                                {{ Form::number('quantity', null, ['max' => 1, 'class' => 'form-control']) }}
                            </div>
                        </div>
                        @endif
                    </p>

                    {{ $ticket_type }}

                </div>
            </div>
        </div>
        @endforeach
    </div>



@endsection
