<div class="modal fade" id="add_organization" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Organization</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="height: 90%;">
                <div class="mb-3">
                    {{ Form::label('organization_name', 'Organization Name') }}
                    {{ Form::text('organization_name', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('organization_website', 'Organization Website') }}
                    {{ Form::text('organization_website', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('cashnet_code', 'Cashnet Code') }}
                    {{ Form::text('cashnet_code', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::submit('Add', ['class' => 'btn btn-primary']) }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
