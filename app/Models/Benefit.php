<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    protected $fillable = [
        'group_id',
        'name',
        'default_amount',
    ];

    // Relationships

    // Group owning this benefit
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Disbursements of this benefit type
    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }
}
