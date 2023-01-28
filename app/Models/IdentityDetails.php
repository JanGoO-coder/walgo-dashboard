<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDetails extends Model
{
    use HasFactory;

    protected $fillables = [
        "type",
        "images",
        "expires_at",
        "number",
        "user_id",
        "archive"
    ];
}
