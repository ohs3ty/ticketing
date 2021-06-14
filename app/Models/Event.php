<?php

namespace App\Models;

use App\Models\Venue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_description',
        'start_date',
        'end_date',
        'venue_id',
        'created_by',
        'updated_by',
        'event_type_id',
        'organization_id'
    ];

    public function getOrganizerNameAttribute() {
        $organizer = Organizer::find($this->updated_by);
        if ($organizer == null) {
            // dd("this is null");
        }
        // dd($this->updated_by);
        return $organizer;
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function ticket_types()
    {
        return $this->hasMany(TicketType::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'updated_by', 'id');
    }

    public static function filters($request, $events)
    {
        $filters = [];
        if (($request->archived) && ($request->archived != 'all')) {
            $events = $events->where('archived', filter_var($request->archived, FILTER_VALIDATE_BOOLEAN));
        }
        if (($request->organization) && ($request->organization != 'all')) {
            $events = $events->where('organizations.organization_name', $request->organization);
        }
        $filters['archived'] = $request->archived;
        $filters['organization'] = $request->organization;
        return $filters;
    }

    public static function formatDate($date, $time)
    {
        // $start_date = \Carbon\Carbon::parse($this->start_date)->format('l, F j, Y, g:i a');
        if ($time == 'time') {
            $date = \Carbon\Carbon::parse($date)->format('g:i a');
        } elseif ($time == 'date_time') {
            $date = \Carbon\Carbon::parse($date)->format('l, F j, Y, g:i a');
        } elseif ($time == 'date') {
            $date = \Carbon\Carbon::parse($date)->format('l, F j, Y');
        } elseif ($time == 'date_notext') {
            $date = \Carbon\Carbon::parse($date);
        } elseif ($time == 'month') {
            $date = \Carbon\Carbon::parse($date)->format('F');
        } elseif ($time == 'day_text') {
            $date = \Carbon\Carbon::parse($date)->format('l');
        } elseif ($time == 'day_num') {
            $date = \Carbon\Carbon::parse($date)->format('j');
        } elseif ($time == 'trad_date') {
            $date = \Carbon\Carbon::parse($date)->format('Y-m-d');
        } elseif ($time == '24_time') {
            $date = \Carbon\Carbon::parse($date)->format('H:i:s');
        }

        return $date;
    }

}
