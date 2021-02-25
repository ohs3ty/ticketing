<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 
    public function index() {
        // show organizers and categorize by the organization
        $organizers = DB::table('organizers')
                        ->join('users','organizers.user_id', '=', 'users.id')
                        ->join('organization_organizers', 'organizers.id', '=', 'organization_organizers.organizer_id')
                        ->join('organizations', 'organizations.id', '=', 'organization_organizers.organization_id')
                        ->select('first_name', 'last_name', 'email', 'organizer_email', 'organizer_phone', 'organization_name')
                        ->orderBy('organization_name')
                        ->get();
        $organizations = Organization::select('organization_name')
                            ->orderBy('organization_name')
                            ->get();

        return view('admin', [
            'organizers' => $organizers,
            'organizations' => $organizations,
            ]);
    }
}
