<!-- Modal -->
<div class="modal fade" id="deleteOrganizer{{ $organizer->id }}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <div class="text-center">
                <h4>Delete Organizer Confirmation</h4>
            </div>    
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p> Are you sure you want to delete {{ $organizer->name }} as an organizer? </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-secondary" data-dismiss="modal">No, go back</button>
            {{ Form::open(array('url' => '/admin/deleteorganizer', 'method' => 'post')) }}
                {{ Form::hidden('organizer_id', $organizer->id) }}
                {{ Form::hidden('organizer', 'true')}}
                {{ Form::submit('Yes, delete', ['class' => 'btn btn-default btn-danger']) }}
            {{ Form::close() }}
            
        </div>
      </div>
      
    </div>
  </div>
