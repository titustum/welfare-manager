<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants, HasDefaultTenant

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

    // 🔐 REQUIRED: Controls access to Filament panel
    public function canAccessPanel(Panel $panel): bool
    {
        // Basic example: allow all users to access
        return true;

        // Optionally restrict to roles:
        // return in_array($this->role, ['admin', 'official']);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    // public function getRoleInGroup($groupId)
    // {
    //     return $this->groups()->where('group_id', $groupId)->first()?->pivot->role;
    // }

    // public function groups(): BelongsToMany
    // {
    //     return $this->belongsToMany(Group::class, 'group_user')->withTimestamps();
    // }

    public function getTenants(Panel $panel): Collection
    {
        return $this->groups;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->groups()->whereKey($tenant)->exists();
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->groups()->first();
    }


    public function getRoleInGroup($groupId): ?string
    {
        return $this->groups()
            ->where('group_id', $groupId)
            ->first()
            ?->pivot
            ?->role;
    }

    public function hasRoleInGroup($groupId, string|array $roles): bool
    {
        $role = $this->getRoleInGroup($groupId);

        return is_array($roles)
            ? in_array($role, $roles)
            : $role === $roles;
    }

    public function isOfficialInGroup($groupId): bool
    {
        return $this->hasRoleInGroup($groupId, ['chair', 'secretary', 'treasurer']);
    }

}