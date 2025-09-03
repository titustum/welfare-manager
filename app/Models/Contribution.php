<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'amount',
        'contribution_date',
    ];

    // Relationships

    // User who made the contribution
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Group to which contribution was made
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
