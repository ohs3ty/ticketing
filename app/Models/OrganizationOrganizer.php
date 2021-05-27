<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationOrganizer extends Model
{
    use HasFactory;

    protected $fillables = [
        'organization_id',
        'organizer_id,'
    ];
}
