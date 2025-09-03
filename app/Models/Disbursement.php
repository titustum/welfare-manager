<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'benefit_id',
        'amount',
        'disbursed_at',
        'status',
        'notes',
    ];

    // Relationships

    // User who received the disbursement
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Group from which disbursement was made
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Benefit type of the disbursement
    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
}
