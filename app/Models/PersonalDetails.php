<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    use HasFactory;

    protected $fillables = [
        "location_id",
        "father_name",
        "mother_name",
        "phone",
        "date_of_birth",
        "about",
        "gender",
        "user_id",
        "archive"
    ];

    public function location() {
        return $this->hasOne(Location::class, "id", "location_id");
    }
}
