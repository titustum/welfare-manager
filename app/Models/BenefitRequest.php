<?php
// app/Models/BenefitRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'benefit_type_id',
        'event_date',
        'relationship',
        'supporting_documents',
        'amount_requested',
        'status',
        'reviewed_by',
        'reviewed_at',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'amount_requested' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function benefitType()
    {
        return $this->belongsTo(BenefitType::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}