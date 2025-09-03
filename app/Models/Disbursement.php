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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
}
