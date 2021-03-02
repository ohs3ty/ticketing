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
          {{ Form::open() }}
          <div class="form-group">
            {{ Form::label('first_name', 'First Name') }}<br>
            {{ Form::text('first_name') }}
          </div>

          <div class="form-group">
            {{ Form::label('last_name', 'Last Name') }}<br>
            {{ Form::text('last_name') }}
          </div>

          <div class="form-group">
              {{ Form::label('organizer_email', 'Organizer Email (if different from personal email)') }}<br>
              {{ Form::text('last_name') }}
          </div>
          
          <div class="form-group">
              {{ Form::label('organizer_phone', 'Organizer Phone') }}<br>
              {{ Form::text('organizer_phone') }}
          </div>
        </div>
        <div class="modal-footer text-left">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{ Form::submit('Add') }}
        </div>
        {{ Form::close() }}
        {{-- make a route for this path (see ajax, but honestly just do the easier way) --}}
    </div>