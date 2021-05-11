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
            <div class="col-8 bg-primary">
              <h3>Event Name</h3>
            </div>
          </div>
            @foreach ($transaction_details as $detail)
              @if($detail->transaction_id == $transaction->transaction_id)
                <div class="row">
                  <div class="col-8 bg-primary">
                    <h4>{{ $detail->event_name }}</h4>
                  </div>
                </div>

                {{ $detail }}
              @endif
            @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  
    </div>
  </div>