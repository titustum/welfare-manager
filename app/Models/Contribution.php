<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contribution extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'amount',
        'period', // updated from contribution_date to period
        'transaction_code',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'period' => 'date',  // casting period as date
    ];

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function contributionPeriods(): HasMany
    {
        return $this->hasMany(ContributionPeriod::class);
    }
}
