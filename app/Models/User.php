<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status',
        'archive',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims() {
        return [
            "user_id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "type" => $this->type,
            "status" => $this->status,
            "session_expires_at" => Carbon::now()->toDateTimeString()
        ];
    }

    public function personalDetails() {
        return $this->belongsTo(PersonalDetails::class, "id", "user_id");
    }

    public function identityDetails() {
        return $this->belongsTo(IdentityDetails::class, "id", "user_id");
    }
}
