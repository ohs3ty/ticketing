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

        return view("admin.organization", [
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

        return view('admin.organization_detail', [
            'organization' => $organization,
            'organizers' => $organizers
        ]);
    }

}
