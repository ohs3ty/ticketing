<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Organizer extends Model
{
    // Note to self: organizer.id should be the same as user.id to make things less complicated
    use HasFactory;

    protected $fillable = [
        'organizer_phone',
        'organizer_email',
        'user_id',
    ];

    public function formatPhone() {
        $phone = "(" . substr($this->organizer_phone, 0, 3) . ") " . substr($this->organizer_phone, 3, 3);
       return $phone;
    }
}
