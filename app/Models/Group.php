<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    // Auto-generate unique code if not set
    protected static function booted()
    {
        static::creating(function ($group) {
            if (empty($group->code)) {
                $group->code = self::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode($length = 6, $prefix = 'GRP-')
    {
        do {
            $code = $prefix . strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }


    // Relationships

    // Users belonging to this group (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Benefits that belong to this group
    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }

    // Contributions made to this group
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    // Disbursements paid out from this group
    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }
}
