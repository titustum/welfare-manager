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
        // Add 'group_id' here if single group per user, else skip
    ];

    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships

    // Groups the user belongs to (many-to-many)
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    // Contributions made by the user
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    // Disbursements received by the user
    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }
}