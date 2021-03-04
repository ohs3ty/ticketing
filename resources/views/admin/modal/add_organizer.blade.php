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
          {{-- adding phone and email if want to --}}
          <div class="form-check">
            {{ Form::checkbox("phone_email", null, null, ['class' => 'form-check-input', 'onclick' => 'addPhoneEmail()', 'id' => 'phone_email']) }}
            {{ Form::label('phone_email', 'Add Phone and/or Email') }}
          </div>
          <div hidden id="phone_email_section">
            <div class="form-group">
                {{ Form::label('organizer_email', 'Organizer Email (if different from personal email)') }}<br>
                {{ Form::text('organizer_email') }}
            </div>
            
            <div class="form-group">
                {{ Form::label('organizer_phone', 'Organizer Phone (no hyphens or parantheses)') }}<br>
                {{ Form::text('organizer_phone', null, ['maxlength' => 10]) }}
            </div>
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

<script>
  function addPhoneEmail() {
    var check = document.getElementById("phone_email");
    if (check.checked == true) {
      document.getElementById("phone_email_section").hidden = false;
    } else {
      document.getElementById("phone_email_section").hidden = true;
      
    }
  }

  document.addEventListener("DOMContentLoaded", function(event) {

    if (document.getElementById("phone_email").checked == true) {
        document.getElementById("phone_email_section").hidden = false;
    }
  })
</script>
