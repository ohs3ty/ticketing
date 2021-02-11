<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_phone',
        'organizer_email',
        'user_id',
        'organization_id',
    ];
}
