<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Organization;
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
}
