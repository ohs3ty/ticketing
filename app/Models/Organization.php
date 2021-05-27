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
        return $this->hasMany(Event::class);
    }

    public function organizers()
    {
        return $this->belongsToMany(Organizer::class)->using(OrganizationOrganizer::class);
    }
}
