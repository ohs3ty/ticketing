<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Organization;
use App\Models\OrganizationOrganizer;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function index() {
        // show organizers and categorize by the organization
        $organizations = Organization::select('organization_name', 'id')
                            ->where('organization_name', '!=', 'admin')
                            ->orderBy('organization_name')
                            ->get();
        $event_types = EventType::select('type_name', 'id')
                        ->orderBy('type_name')
                        ->get();
        $organizers = Organizer::select('users.name', 'organizers.id')
                        ->join('users', 'users.id', '=', 'organizers.user_id')
                        ->orderBy('users.name')
                        ->get();
        $organization_organizers = OrganizationOrganizer::select()
                                    ->join('organizations', 'organizations.id', '=', 'organization_organizers.organization_id')
                                    ->get();

        return view('admin.admin', [
            'organizations' => $organizations,
            'event_types' => $event_types,
            'organizers' => $organizers,
            'organization_organizers' => $organization_organizers,
            ]);
    }

    public function add_organization() {

        return view('admin.add_organization');
    }

    public function add_organization_action(Request $request) {
        // validator
        $validated = $request->validate([
            'organization_name' => 'bail|required|unique:organizations',
            'cashnet_code' => 'required',
        ]);

        $new_organization = new Organization();
        $new_organization->organization_name = $request->organization_name;
        $new_organization->cashnet_code = $request->cashnet_code;
        $new_organization->organization_website = $request->organization_website;
        $new_organization->save();
        return redirect('/admin');
    }

    public function edit_organization_action(Request $request) {
        $organization_id = $request->organization_id;

        $validated = $request->validate([
            'organization_name' => 'bail|required',
        ]);

        $edit_organization = Organization::find($organization_id);
        $edit_organization->organization_name = $request->organization_name;
        $edit_organization->cashnet_code = $request->cashnet_code;
        $edit_organization->organization_website = $request->organization_website;
        $edit_organization->save();

        return back();
    }

    public function organization_detail(Request $request) {
        $organization_name = $request->name;

        $organization = Organization::where('organization_name', '=', $organization_name)
                            ->first();
        $organizers = Organizer::select('organizer_email', 'organizers.id', 'organizer_phone', 'name', 'email')
                        ->where('organization_name', '=', $organization_name)
                        ->join('organization_organizers', 'organization_organizers.organizer_id', '=', 'organizers.id')
                        ->join('organizations', 'organizations.id','=', 'organization_organizers.organization_id')
                        ->join('users', 'users.id', '=', 'organizers.user_id')
                        ->orderBy('name')
                        ->get();

        return view('admin.organization_detail', [
            'organization' => $organization,
            'organizers' => $organizers,
        ]);
    }

    public function add_organizer_action(Request $request) {

        $validated = $request->validate([
            'first_name' => 'bail|required',
            'last_name' => 'required',
        ]);

        $org_bool_count = 1;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $name = $first_name . " " . $last_name;
        $organization_id = intval($request->organization_id);

        $organization = Organization::select('organization_name')
                                ->where('id', $organization_id)
                                ->first();


        $user = User::where('name', $name)
        ->first();


        if ($user) {

            if (($user->role == "admin")) {
                $organizer_bool = Organizer::where('user_id', $user->id)
                                    ->get();
                $org_bool_count = count($organizer_bool);

            }
            if (($user->role == "general") or ($org_bool_count == 0)) {
                $validated = $request->validate([
                    'organizer_phone' => 'required|regex:/[0-9]{10}/',
                ]);

                if ($user->role == "general") {
                    $user->role = 'organizer';
                    $user->save();
                }

                $new_organizer = new Organizer;
                $new_organizer->user_id = $user->id;

                //if no email recorded
                if (empty($request->organizer_email)) {
                    $new_organizer->organizer_email = $user->email;
                } else {
                    $new_organizer->organizer_email = $request->organizer_email;
                }
                $new_organizer->organizer_phone = $request->organizer_phone;
                $new_organizer->save();

            }
                $organizer_id = Organizer::select('id')
                    ->where('user_id', $user->id)
                    ->first();

            // if admin, change user to admin role to give them admin privileges

                if ($organization->organization_name == 'admin') {
                    $user->role = 'admin';
                    $user->save();
                }

                // look to see if they are already an organizer in this organization
                $find_organizer = OrganizationOrganizer::where('organizer_id', $organizer_id->id)
                                    ->where('organization_id', $organization_id)
                                    ->get();

                if (count($find_organizer) > 0) {
                    $msg = 'The user you\'re trying to add is already an organizer for this organization.';
                    return Redirect::back()->withErrors(['general' => $msg]);

                } else {
                    $organization_organizer = new OrganizationOrganizer;
                    $organization_organizer->organizer_id = $organizer_id->id;
                    $organization_organizer->organization_id = $organization_id;
                    $organization_organizer->save();
                }

        } else {
            // if user does not exist return error
            $msg = 'This user does not exist. Check for mispellings or make sure he or she is BYU affiliated.';
            return Redirect::back()->withErrors(['general' => $msg]);
        }


        return back();
    }

    public function edit_organizer_action(Request $request) {
        $validated = $request->validate([
            'organizer_phone' => 'required|regex:/[0-9]{10}/',
            'organizer_email' => 'required|email',
        ]);

        $organizer_id = $request->organizer_id;

        $edit_organizer = Organizer::find($organizer_id);
        $edit_organizer->organizer_phone = $request->organizer_phone;
        $edit_organizer->organizer_email = $request->organizer_email;
        $edit_organizer->save();

        return back();
    }

    public function delete_organizer(Request $request) {
        $organizer_id = $request->organizer_id;
        


        if ($request->deleteorganizer == "true") {
            $organizer_organization = OrganizationOrganizer::where('organizer_id', $request->organizer_id)->get();
            foreach($organizer_organization as $org) {
                $org->delete();
            }
            
            $organizer = Organizer::where('id', $request->organizer_id)->first();
            $user = User::where('id', $organizer->user_id)->first();
            if ($user->role != 'admin') {
                $user->resetRole();
            }
            $organizer->delete();


            return back();
        } 

        $organization_id = $request->organization_id;
        $organization = Organization::where('id', $organization_id)->first();

        //if user has other organizations, they stay organizer, otherwise, back to general
        $num_org = OrganizationOrganizer::where('organizer_id', $organizer_id)
                                ->join('organizations', 'organization_organizers.organization_id', '=', 'organizations.id')
                                ->where('organization_name', '!=', 'admin')
                                ->get();

        $user = User::join('organizers', 'users.id', '=', 'organizers.user_id')
                    ->where('organizers.id', $organizer_id)
                    ->first();
            if (count($num_org) == 0) {
                $user->role = 'general';
                $user->save();
            } else {
                if ($organization->organization_name == 'admin') {
                    $user->role = 'organizer';

                    $user->save();
                }
            }

        OrganizationOrganizer::where('organization_id', $organization_id)
            ->where('organizer_id', $organizer_id)
            ->delete();

        return back();

    }

}
