<?php

namespace App\Policies;

use App\Models\Benefit;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Filament\Facades\Filament;

class BenefitPolicy
{
    /**
     * Determine whether the user can view any benefits.
     */
    public function viewAny(User $user): bool
    {
        // Allow users to view benefits of their group (tenant)
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        return $user->groups->contains($group);
    }

    /**
     * Determine whether the user can view a benefit.
     */
    public function view(User $user, Benefit $benefit): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        return $user->groups->contains($group) && $benefit->group_id === $group->id;
    }

    /**
     * Determine whether the user can create a benefit.
     */
    public function create(User $user): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // Only officials can create benefits
        return $user->hasRoleInGroup($group->id, ['chair', 'secretary', 'treasurer']);
    }

    /**
     * Determine whether the user can update the benefit.
     */
    public function update(User $user, Benefit $benefit): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // Only officials in the group owning this benefit can update
        return $benefit->group_id === $group->id
            && $user->hasRoleInGroup($group->id, ['chair', 'secretary', 'treasurer']);
    }

    /**
     * Determine whether the user can delete the benefit.
     */
    public function delete(User $user, Benefit $benefit): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // Only officials in the group owning this benefit can delete
        return $benefit->group_id === $group->id
            && $user->hasRoleInGroup($group->id, ['chair', 'secretary', 'treasurer']);
    }

    /**
     * Determine whether the user can restore the benefit.
     */
    public function restore(User $user, Benefit $benefit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the benefit.
     */
    public function forceDelete(User $user, Benefit $benefit): bool
    {
        return false;
    }
}
