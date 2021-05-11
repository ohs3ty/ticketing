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
          @foreach ($transaction_details as $detail)
            {{$detail}}
          @endforeach
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  
    </div>
  </div>