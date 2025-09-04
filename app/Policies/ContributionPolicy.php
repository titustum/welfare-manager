<?php

namespace App\Policies;

use App\Models\Contribution;
use App\Models\User;
use Filament\Facades\Filament;

class ContributionPolicy
{
    /**
     * Determine whether the user can view any contributions.
     */
    public function viewAny(User $user): bool
    {
        // Allow viewing contributions only if user belongs to current group
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        return $user->groups->contains($group);
    }

    /**
     * Determine whether the user can view a specific contribution.
     */
    public function view(User $user, Contribution $contribution): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // User must belong to the contribution's group
        return $contribution->group_id === $group->id
            && $user->groups->contains($group);
    }

    /**
     * Determine whether the user can create a contribution.
     */
    public function create(User $user): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // Only treasurer can create contributions
        return $user->hasRoleInGroup($group->id, 'treasurer');
    }

    /**
     * Determine whether the user can update the contribution.
     */
    public function update(User $user, Contribution $contribution): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // Only treasurer can update contributions within their group
        return $contribution->group_id === $group->id
            && $user->hasRoleInGroup($group->id, 'treasurer');
    }

    /**
     * Determine whether the user can delete the contribution.
     */
    public function delete(User $user, Contribution $contribution): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        // Only treasurer can delete contributions within their group
        return $contribution->group_id === $group->id
            && $user->hasRoleInGroup($group->id, 'treasurer');
    }

    /**
     * Determine whether the user can restore the contribution.
     */
    public function restore(User $user, Contribution $contribution): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the contribution.
     */
    public function forceDelete(User $user, Contribution $contribution): bool
    {
        return false;
    }
}
