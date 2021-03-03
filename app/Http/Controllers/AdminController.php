<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Organization;
use App\Models\OrganizationOrganizer;
use App\Models\User;
use App\Http\Controllers\AdminController;
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
            'organizer_phone' => 'required|regex:/[0-9]{10}/',
        ]);

        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $organization_id = intval($request->organization_id);

        $user = User::where('first_name', $first_name)
        ->where('last_name', $last_name)
        ->first();

        if ($user) {
            if (($user->role == "admin") or ($user->role == 'organizer')) {
                //nothing should happen
                
            } else {
                $user->role = 'organizer';
                // $user->save();
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

                $organization_organizer = new OrganizationOrganizer;
                $organization_organizer->organizer_id = $organizer_id->id;
                $organization_organizer->organization_id = $organization_id;
                $organization_organizer->save();

                print($organization_organizer);
                print($user);
            print("\n");
        }

        $organization_name = Organization::select('organization_name')
                                ->where('id', $organization_id)
                                ->first();

                                // it's not redirecting
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
