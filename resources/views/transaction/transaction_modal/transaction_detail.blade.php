<!-- Modal -->
<div id="{{$transaction->transaction_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h2>Order #{{ $transaction->transaction_id }}</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-4">
              <h4>Event Details</h4>
            </div>
            <div class="col-2">
              <h4>Ticket Detail</h4>
            </div>
          </div>
            @foreach ($transaction_details as $detail)
              @if($detail->transaction_id == $transaction->transaction_id)
                <div class="row">
                  <div class="col-4 bg-primary">
                    <h5>{{ $detail->event_name }}</h5>
                    {{\Carbon\Carbon::parse($detail->start_date)->format("F j, Y g:i a")}}

                  </div>
                  <div class="col-2">
                    <h5>${{ number_format($detail->ticket_cost, 2, ".", ",") }}</h5>
                  </div>
                </div>

              @endif
            @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  
    </div>
  </div>