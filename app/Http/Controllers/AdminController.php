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
    public function organization_index() {
        $organizations = Organization::all()->sortBy('organization_name');

        return view("organization.organization", [
            'organizations' => $organizations,
        ]);
    }

    public function organization_detail(Request $request) {
        $organization = Organization::where('id', $request->organization_id)
                            ->first();
        $organizers = Organizer::select('organizers.id', 'organizer_email', 'organizer_phone', 'users.preferredSurname', 'users.id as user_id')
                        ->join('organization_organizers', 'organization_organizers.organizer_id', '=', 'organizers.id')
                        ->join('users', 'users.id', '=', 'organizers.user_id')
                        ->where('organization_organizers.organization_id', $request->organization_id)
                        ->orderBy('preferredSurname')
                        ->get();
        $query = OrganizationOrganizer::select('organizer_id')
                ->from('organization_organizers')
                ->where('organization_id', $request->organization_id);
        $dropdown_organizers = Organizer::select('organizers.id', DB::raw('CONCAT(users.preferredFirstName, " ", users.preferredSurname) as full_name'))
                                ->join('users', 'users.id', '=', 'organizers.user_id')
                                ->whereNotIn('organizers.id', $query)
                                ->pluck('full_name', 'organizers.id');
        return view('organization.organization_detail', [
            'organization' => $organization,
            'organizers' => $organizers,
            'dropdown_organizers' => $dropdown_organizers,
        ]);
    }

    public function edit_organization(Request $request) {
        if ($request->add_detail == 'add_organizer') {
            $organization_organizer =  new OrganizationOrganizer;
            $organization_organizer->organizer_id = $request->organizer_id;
            $organization_organizer->organization_id = $request->organization_id;
            $organization_organizer->save();
        } else {
            $organization = Organization::find($request->organization_id);
            $organization->organization_website = $request->website_input;
            $organization->cashnet_code = $request->cashnet_input;
            $organization->save();
        }
        return redirect()->route('organization.organization-detail', [$request->organization_id]);
    }

    public function delete_organizer(Request $request) {
        OrganizationOrganizer::where('organization_id', $request->organization_id)
                        ->where('organizer_id', $request->organizer_id)
                        ->delete();
        return redirect()->route('organization.organization-detail', [$request->organization_id]);
    }

}
