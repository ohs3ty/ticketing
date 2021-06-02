<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'cashnet_code',
        'organization_website',
    ];

    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('start_date');
    }

    public function organizers()
    {
        return $this->hasManyThrough(Organizer::class, OrganizationOrganizer::class, 'organization_id', 'id', 'id', 'organizer_id');
    }
}
