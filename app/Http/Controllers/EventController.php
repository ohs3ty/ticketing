<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use JavaScript;

use App\Models\EventType;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Venue;
use App\Models\Organization;

class EventController extends Controller
{
    //
    public function index() {
        
    }
    public function addview(Request $request) {
        // javascript
        // JavaScript::put([
        //     'organizations' => Organization::pluck('organization_name')->sort(),
        // ]);

        $user_id = intval($request->id);
        $event_types = EventType::pluck('type_name')->sort();
        $organizer = Organizer::where('user_id', $user_id)
                        ->first();
        $organizations = DB::table('organizers')->select('organization_name')
                        ->join('organization_organizer', 'organization_organizer.organizer_id', '=', 'organizers.id')
                        ->join('organizations', 'organization_organizer.organization_id', '=', 'organizations.id')
                        ->where('organizers.user_id', $user_id)
                        ->get();

        $organization_names = $organizations->pluck('organization_name');
        $venues = Venue::pluck('venue_name');

        return view('event.addview', 
    [
        'event_types' => $event_types,
        'user_id' => $user_id,
        'organizer' => $organizer,
        'organization_names' => $organization_names,
        'venues' => $venues,
    ]);
    }

    public function addeventaction(Request $request) {
        // validation
        $validated = $request->validate([
            'event_name' => ['bail', 'required'],
        ]);
        $user_id = $request->input('user_id');

        Organizer::where('user_id', $user_id)
            ->update(['organizer_phone' => $request->input('organizer_phone')]);
        Organizer::where('user_id', $user_id)
            ->update(['organizer_email' => $request->input('organizer_email')]);
            
        $event_name = $request->input('event_name');
        $start_date = date("Y-m-d H:i:s", strtotime("{$request->input('start_date')} {$request->input('start_time')}"));
        $end_date = date("Y-m-d H:i:s", strtotime("{$request->input('end_date')} {$request->input('end_time')}"));
        $event_type = ($request->input('event_type') + 1);
        $event_description = $request->input('event_description');
        $organizer_id = Organizer::where('user_id', $user_id)->get()->first()->id;
        $organization_id = ($request->input('organization_name') + 1);
        $venue = $request->input('venue');

        // see if the venue needs to be added to database or simply added as an id to the event
        $add_venue_bool = $request->input('new_venue');

        if ($add_venue_bool == 1) {
            $new_venue = new Venue;
            $new_venue->venue_name = $venue;
            $new_venue->venue_addr = $request->input('venue_addr');
            $new_venue->venue_zipcode = $request->input('venue_zipcode');
            $new_venue->save();
        }

        $venue_id = Venue::where('venue_name', $venue)->get()->first()->id;
        
        $new_event = new Event;
        $new_event->event_name = $event_name;
        $new_event->event_description = $event_description;
        $new_event->start_date = $start_date;
        $new_event->end_date = $end_date;
        $new_event->event_type_id = $event_type;
        $new_event->organizer_id = $organizer_id;
        $new_event->organization_id = $organization_id;
        $new_event->venue_id = $venue_id;
        $new_event->save();
            

        return ("success");
        // get the organizer and organization info

        
    }

}
