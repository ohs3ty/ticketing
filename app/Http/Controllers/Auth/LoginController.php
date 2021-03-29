<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpCAS;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        phpCAS::client(CAS_VERSION_2_0, 'cas.byu.edu', 443, 'cas');
        phpCAS::setNoCasServerValidation();
        if (phpCAS::isSessionAuthenticated())
            phpCAS::logout();
        return redirect('/');
    }
}
