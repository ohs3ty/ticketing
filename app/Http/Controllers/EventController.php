<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use JavaScript;

use App\Models\EventType;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Venue;
use App\Models\Organization;
use App\Models\TicketType;

class EventController extends Controller
{
    //
    public function index() {

        $events = Event::select('events.id', 'event_name', 'event_description', 'start_date', 'end_date', 'created_by', 'updated_by', 'venue_id',
                                    'event_type_id', 'organization_id', DB::raw('COUNT(ticket_types.id) AS ticket_type_count'))
                    ->orderBy('start_date')
                    ->leftJoin('ticket_types', 'ticket_types.event_id', '=', 'events.id')
                    ->groupBy('events.id', 'event_name', 'event_description', 'start_date', 'end_date', 'created_by', 'updated_by', 'venue_id',
                    'event_type_id', 'organization_id')
                    ->get();
        $ticket_types = TicketType::all();

        $ticket_counts = Event::select('events.id', 'event_name', 'ticket_types.ticket_name', 'ticket_types.ticket_open_date',
                                    'ticket_types.ticket_close_date', 'ticket_types.ticket_cost', 'ticket_types.ticket_limit',
                                    DB::raw('(ticket_limit - ticket_count) as ticket_left'))
                            ->leftJoin('ticket_types', 'ticket_types.event_id', 'events.id')
                            ->leftJoin(DB::raw("(SELECT ticket_types.id, count(transaction_tickets.id) as ticket_count from ticket_types
                                                LEFT JOIN transaction_tickets on transaction_tickets.ticket_type_id = ticket_types.id
                                                GROUP BY ticket_types.id)
                                                AS tc"), 'ticket_types.id', '=', 'tc.id')
                            ->orderBy('ticket_types.ticket_name')
                            ->get();


        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('event.event_index', [
            'events' => $events,
            'months' => $months,
            'ticket_types' => $ticket_types,
            'ticket_counts' => $ticket_counts,
        ]);
    }


    public function view_user_events(Request $request) {
        $user_id = intval($request->id);
        // I want all events created by the user's organization (regardless if it was created by the organizer)
        // I have to find the user's organizations (because one user could possibly be in more than one organization)
        // then get those events by organization

        // also if the event has already passed, it should go somewhere else ***** maybe create an archived event table?


        $events = Event::select('events.id', 'event_name', 'event_description', 'start_date', 'end_date', 'organizations.organization_name')
                ->whereIn('organization_id', function($query) use ($user_id) {
                    $query->select('organizations.id')
                            ->from('organizations')
                            ->join('organization_organizers', 'organization_organizers.organization_id', '=', 'organizations.id')
                            ->join('organizers', 'organizers.id', '=', 'organization_organizers.organizer_id')
                            ->where('organizers.user_id', $user_id);

                })
                ->join('organizations', 'organizations.id', '=', 'events.organization_id')
                ->orderBy('start_date')->paginate(8);


        $events->withPath("/myevents?id=$user_id");

        return view('event.user_events', [
            'user_id' => $user_id,
            'events' => $events,
        ]);
    }


    public function addevent(Request $request) {

        $user_id = intval($request->id);
        $event_types = EventType::pluck('type_name')->sort();
        $organizer = Organizer::where('user_id', $user_id)
                        ->first();
        $organizations = DB::table('organizers')->select('organizations.id', 'organization_name')
                        ->join('organization_organizers', 'organization_organizers.organizer_id', '=', 'organizers.id')
                        ->join('organizations', 'organization_organizers.organization_id', '=', 'organizations.id')
                        ->where('organizers.user_id', $user_id)
                        ->where('organization_name', '!=', 'admin')
                        ->get();

        $organization_names = $organizations->pluck('organization_name', 'id');
        $venues = Venue::pluck('venue_name');

        return view('event.add_event',
    [
        'event_types' => $event_types,
        'user_id' => $user_id,
        'organizer' => $organizer,
        'organizations' => $organizations,
        'organization_names' => $organization_names,
        'venues' => $venues,
    ]);
    }


    public function add_event_action(Request $request) {
        // validation
        $validated = $request->validate([
            'event_name' => 'bail|required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'venue' => 'required',
            'organizer_phone' => 'required',
            'organizer_email' => 'required',
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
        $organization_id = ($request->input('organization_name'));
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

        try {
            $venue_id = Venue::where('venue_name', $venue)->get()->first()->id;

        } catch (\Exception $e) {

            $msg = "Please check the box if adding a new venue or choose an existing location listed under the input box.";

            return Redirect::back()->withErrors(['venue_error' => $msg]);
        }



        // $venue_id = Venue::where('venue_name', $venue)->get()->first()->id;

        $new_event = new Event;
        $new_event->event_name = $event_name;
        $new_event->event_description = $event_description;
        $new_event->start_date = $start_date;
        $new_event->end_date = $end_date;
        $new_event->event_type_id = $event_type;
        $new_event->created_by = $organizer_id;
        $new_event->updated_by = $organizer_id;
        // Adding one because the first organization is the admin
        $new_event->organization_id = ($organization_id);
        $new_event->venue_id = $venue_id;
        $new_event->save();

        // return ($new_event->id);
        return redirect('/events');
        // get the organizer and organization info


    }

    public function edit_event(Request $request) {
        $event_id = $request->event_id;
        $user_id = $request->user_id;

        $event_types = EventType::pluck('type_name')->sort();
        $organizer = Organizer::where('user_id', $user_id)
                        ->first();
        $organizations = DB::table('organizers')->select('organizations.id', 'organization_name')
                        ->join('organization_organizers', 'organization_organizers.organizer_id', '=', 'organizers.id')
                        ->join('organizations', 'organization_organizers.organization_id', '=', 'organizations.id')
                        ->where('organizers.user_id', $user_id)
                        ->where('organization_name', '!=', 'admin')
                        ->get();

        $organization_names = $organizations->pluck('organization_name', 'id');
        $venues = Venue::pluck('venue_name');

        $event = Event::where('events.id', $event_id)
                    ->join('venues', 'venues.id', '=', 'events.venue_id')
                    ->join('organizations', 'organizations.id', '=', 'events.organization_id')
                    ->first();

        return view('event.edit_event', [
            'event' => $event,
            'event_types' => $event_types,
            'organizer' => $organizer,
            'organizations' => $organizations,
            'organization_names' => $organization_names,
            'venues' => $venues,
            'user_id' => $user_id,
            'event_id' => $event_id,
        ]);
    }


    public function edit_event_action(Request $request) {
        $validated = $request->validate([
            'event_name' => 'bail|required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'venue' => 'required',
            'organizer_phone' => 'required',
            'organizer_email' => 'required',
        ]);

        $event_id = $request->event_id;
        $user_id = $request->user_id;

        $organizer = Organizer::where('user_id', $user_id)->first();

        $start_date = date("Y-m-d H:i:s", strtotime("{$request->input('start_date')} {$request->input('start_time')}"));
        $end_date = date("Y-m-d H:i:s", strtotime("{$request->input('end_date')} {$request->input('end_time')}"));
        $venue = $request->venue;
        $add_venue_bool = $request->input('new_venue');

        if ($add_venue_bool == 1) {
            $new_venue = new Venue;
            $new_venue->venue_name = $venue;
            $new_venue->venue_addr = $request->input('venue_addr');
            $new_venue->venue_zipcode = $request->input('venue_zipcode');
            $new_venue->save();
        }

        try {
            $venue_id = Venue::where('venue_name', $venue)->get()->first()->id;

        } catch (\Exception $e) {

            $msg = "Please check the box if adding a new venue or choose an existing location listed under the input box.";

            return Redirect::back()->withErrors(['venue_error' => $msg]);
        }


        $event = Event::find($event_id);
        $event->event_name = $request->event_name;
        $event->start_date = $start_date;
        $event->end_date = $end_date;
        $event->event_type_id = ($request->event_type + 1);
        $event->event_description = $request->event_description;
        $event->venue_id = $venue_id;
        $event->updated_by = $organizer->id;
        $event->organization_id = ($request->organization_name);


        $organizer_phone = $request->organizer_phone;
        $organizer_email = $request->organizer_email;
        Organizer::where('user_id', $user_id)
            ->update(['organizer_phone' => $organizer_phone, 'organizer_email' => $organizer_email]);

        $event->save();

        return redirect()->route('myevents', ['id' => $user_id]);
    }

    public function delete_event(Request $request) {
        // first drop ticket type because it is foreign keyed into event
        // if ticket types already have customers who bought them, then we have to know which customers bought
        // so we can refund them
        // Should NOT be able to delete an event 24 hours (or even more) before
        $event = Event::find($request->event_id);
        TicketType::where('event_id', $request->event_id)->delete();
        $event->delete();

        return redirect()->route("myevents", ['id' => $request->user_id]);
    }

    public function event_detail(Request $request) {

        return view('event.event_detail');
    }
}
