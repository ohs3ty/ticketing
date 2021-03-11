<?php

namespace App\Http\Controllers;

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
                            ->orderBy('organization_name')
                            ->get();

        return view('admin.admin', [
            'organizations' => $organizations,
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
        $organizers = Organizer::select('organizer_email', 'organizers.id', 'organizer_phone', 'first_name', 'last_name', 'email')
                        ->where('organization_name', '=', $organization_name)
                        ->join('organization_organizers', 'organization_organizers.organizer_id', '=', 'organizers.id')
                        ->join('organizations', 'organizations.id','=', 'organization_organizers.organization_id')
                        ->join('users', 'users.id', '=', 'organizers.user_id')
                        ->orderBy('last_name')
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
            // 'organizer_phone' => 'regex:/[0-9]{10}/',
        ]);


        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $organization_id = intval($request->organization_id);

        // if admin, change user to admin role to give them admin privileges
        $organization_name = Organization::select('organization_name')
                                ->where('id', $organization_id)
                                ->first();

        if ($organization_name == 'admin') {
            dd("treu");
        }

        $user = User::where('first_name', $first_name)
        ->where('last_name', $last_name)
        ->first();


        if ($user) {

            if (($user->role == "admin") or ($user->role == 'organizer')) {
                // pass

            }

            if (($user->role == "general")) {
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
        $organization_id = $request->organization_id;
        OrganizationOrganizer::where('organization_id', $organization_id)
            ->where('organizer_id', $organizer_id)
            ->delete();

        return back();

    }
}
