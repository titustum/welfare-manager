<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'period',      // The month/year this period refers to (e.g. 2025-09-01)
        'amount_due',  // Expected monthly contribution (e.g. 300)
        'amount_paid', // How much has been paid for this period
        'paid',        // boolean if fully paid
    ];

    protected $casts = [
        'period' => 'date',
        'paid' => 'boolean',
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }
}

