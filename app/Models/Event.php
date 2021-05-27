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

}
