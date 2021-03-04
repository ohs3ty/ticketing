<!-- Modal -->
<div id="editOrganizer{{$organizer->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <div class="text-center">
            <h4>Edit Email and Phone for {{$organizer->first_name}} {{$organizer->last_name}}</h4>
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          {{ Form::open(array('url' => '/admin/editorganizer', 'method' => 'post')) }}
          
            <div class="form-group">
                {{ Form::label('organizer_email', 'Organizer Email (if different from personal email)') }}<br>
                {{ Form::text('organizer_email', $organizer->organizer_email) }}
            </div>
            
            <div class="form-group">
                {{ Form::label('organizer_phone', 'Organizer Phone (no hyphens or parantheses)') }}<br>
                {{ Form::text('organizer_phone', $organizer->organizer_phone, ['maxlength' => 10]) }}
            </div>
          </div>
        <div class="modal-footer text-left">
            {{ Form::hidden('organizer_id', $organizer->id )}}
            <button type="button" class="btn btn-secondary btn-default" data-dismiss="modal">Close</button>
            {{ Form::submit('Edit Organizer', ['class' => 'btn btn-primary btn-default']) }}
        </div>
        {{ Form::close() }}
    </div>
    </div>
</div>
