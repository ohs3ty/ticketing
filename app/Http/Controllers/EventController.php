<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Organization;
use Illuminate\Console\Scheduling\Event;
use JavaScript;

class EventController extends Controller
{
    //
    public function addview(Request $request) {
        // javascript
        // JavaScript::put([
        //     'organizations' => Organization::pluck('organization_name')->sort(),
        // ]);
        $user_id = intval($request->id);
        $event_types = EventType::pluck('type_name')->sort();
    

        return view('event.addview', 
    [
        'event_types' => $event_types,
        'user_id' => $user_id,
    ]);
    }

}
