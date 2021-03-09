<!-- Modal -->
<div class="modal fade" id="editOrganization" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <div class="text-center">
                <h4>Edit Organization Info</h4>
            </div>    
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            {{ Form::open(array('url' => '/admin/editorganization', 'method' => 'post')) }}
            <div class="form-group">
                {{ Form::label('organization_name', 'Organization Name')}}<br>
                {{ Form::text('organization_name', $organization->organization_name)}}
            </div>

            <div class="form-group">
                {{ Form::label('cashnet_code', 'Cashnet Code')}}<br>
                {{ Form::text('cashnet_code', $organization->cashnet_code)}}
            </div>

            <div class="form-group">
                {{ Form::label('organization_website', 'Organization Website')}}<br>
                {{ Form::text('organization_website', $organization->organization_website)}}
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-secondary" data-dismiss="modal">Cancel</button>
                {{ Form::hidden('organization_id', $organization->id) }}
                {{ Form::submit('Edit Organization', ['class' => 'btn btn-default btn-primary']) }}
            {{ Form::close() }}
            
        </div>
      </div>
      
    </div>
  </div>
