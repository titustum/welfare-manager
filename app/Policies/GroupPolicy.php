<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    /**
     * Determine whether the user can view any groups.
     */
    public function viewAny(User $user): bool
    {
        // Allow listing groups user belongs to
        return true;
    }

    /**
     * Determine whether the user can view a specific group.
     */
    public function view(User $user, Group $group): bool
    {
        // User must belong to the group to view it
        return $user->groups->contains($group);
    }

    /**
     * Determine whether the user can create groups.
     */
    public function create(User $user): bool
    {
        // Restrict group creation to admins only, if you want
        return $user->role === 'admin'; 
    }

    /**
     * Determine whether the user can update the group.
     */
    public function update(User $user, Group $group): bool
    {
        // Only chair can update group details
        return $user->hasRoleInGroup($group->id, 'chair');
    }

    /**
     * Determine whether the user can delete the group.
     */
    public function delete(User $user, Group $group): bool
    {
        // Only chair can delete the group
        return $user->hasRoleInGroup($group->id, 'chair');
    }

    /**
     * Determine whether the user can restore the group.
     */
    public function restore(User $user, Group $group): bool
    {
        return false; // Or restrict to chair if you implement soft deletes
    }

    /**
     * Determine whether the user can permanently delete the group.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        return false; // Or restrict to chair if needed
    }
}
