<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'student_id',
        'staff_id',
        'role',
        'status',
        'joined_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'joined_at' => 'date',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function benefitRequests()
    {
        return $this->hasMany(BenefitRequest::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviewedBenefitRequests()
    {
        return $this->hasMany(BenefitRequest::class, 'reviewed_by');
    }
}