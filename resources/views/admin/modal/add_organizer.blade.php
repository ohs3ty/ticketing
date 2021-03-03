<!-- Modal -->
<div id="addOrganizer" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <div class="text-center">
            <h4>Add Organizer</h4>
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          {{ Form::open(array('url' => '/admin/addorganizer', 'method' => 'post')) }}
          <div class="form-group">
            {{ Form::label('first_name', 'First Name') }}<br>
            {{ Form::text('first_name', null, ['required']) }}
          </div>

          <div class="form-group">
            {{ Form::label('last_name', 'Last Name') }}<br>
            {{ Form::text('last_name', null, ['required']) }}
          </div>

          <div class="form-group">
              {{ Form::label('organizer_email', 'Organizer Email (if different from personal email)') }}<br>
              {{ Form::text('organizer_email') }}
          </div>
          
          <div class="form-group">
              {{ Form::label('organizer_phone', 'Organizer Phone (no hyphens or parantheses)') }}<br>
              {{ Form::text('organizer_phone', null, ['required', 'maxlength' => 10]) }}
          </div>
        </div>
        <div class="modal-footer text-left">
            {{ Form::hidden('organization_id', $organization->id )}}
            <button type="button" class="btn btn-secondary btn-default" data-dismiss="modal">Close</button>
            {{ Form::submit('Add Organizer', ['class' => 'btn btn-primary btn-default']) }}
        </div>
        {{ Form::close() }}
        {{-- make a route for this path (see ajax, but honestly just do the easier way) --}}
    </div>
    </div>
</div>
