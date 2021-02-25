<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTimes;
use DateInterval;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = date_add(now(), date_interval_create_from_date_string("7 days"));
        $events = Event::where('start_date', '>=', now())
                    ->where('start_date', '<=', $date)
                    ->orderBy('start_date')
                    ->get();

        return view('home', [
            'events' => $events,
        ]);
    }
}
