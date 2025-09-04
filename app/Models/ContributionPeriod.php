<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionPeriod extends Model
{
    protected $fillable = [
        'contribution_id',
        'user_id',
        'group_id',
        'month',
        'year',
        'amount',
    ];

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}

