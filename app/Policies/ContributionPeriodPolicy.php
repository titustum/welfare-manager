<?php

namespace App\Policies;

use App\Models\ContributionPeriod;
use App\Models\User;
use Filament\Facades\Filament;

class ContributionPeriodPolicy
{
    /**
     * Determine whether the user can view any ContributionPeriod models.
     */
    public function viewAny(User $user): bool
    {
        // Allow only if user belongs to current tenant group
        $tenant = Filament::getTenant();
        return $tenant && $user->groups->contains($tenant);
    }

    /**
     * Determine whether the user can view a specific ContributionPeriod.
     */
    public function view(User $user, ContributionPeriod $contributionPeriod): bool
    {
        $tenant = Filament::getTenant();
        return $tenant
            && $user->groups->contains($tenant)
            && $contributionPeriod->group_id === $tenant->id;
    }

    /**
     * Determine whether the user can create ContributionPeriods.
     * Usually only officials like Treasurer or Admin can create/update.
     */
    public function create(User $user): bool
    {
        $tenant = Filament::getTenant();
        if (! $tenant) {
            return false;
        }

        // Check if user is an official in this tenant/group (e.g. Treasurer or Admin)
        $role = $user->getRoleInGroup($tenant->id);

        return in_array($role, ['admin', 'treasurer']);
    }

    /**
     * Determine whether the user can update a ContributionPeriod.
     * Same as create.
     */
    public function update(User $user, ContributionPeriod $contributionPeriod): bool
    {
        $tenant = Filament::getTenant();

        if (! $tenant || $contributionPeriod->group_id !== $tenant->id) {
            return false;
        }

        $role = $user->getRoleInGroup($tenant->id);

        return in_array($role, ['admin', 'treasurer']);
    }

    /**
     * Determine whether the user can delete a ContributionPeriod.
     */
    public function delete(User $user, ContributionPeriod $contributionPeriod): bool
    {
        return $this->update($user, $contributionPeriod);
    }

    /**
     * Determine whether the user can restore a ContributionPeriod.
     */
    public function restore(User $user, ContributionPeriod $contributionPeriod): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete a ContributionPeriod.
     */
    public function forceDelete(User $user, ContributionPeriod $contributionPeriod): bool
    {
        return false;
    }
}
