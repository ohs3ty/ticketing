<div id="event{{$event->event_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <div class="text-left">
                <h4>Details for {{ $event->event_name }}</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            Start Date: {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

    </div>
</div>
