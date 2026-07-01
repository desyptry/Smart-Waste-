<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'address',
        'phone_number',
        'profile_picture',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function dropOffPoints(): HasMany
    {
        return $this->hasMany(DropOffPoint::class, 'assesor_id');
    }

    public function citizenDetail(): HasOne
    {
        return $this->hasOne(CitizenDetail::class, 'user_id');
    }
    
    public function officerDetail(): HasOne
    {
        return $this->hasOne(OfficerDetail::class, 'user_id');
    }
}   
