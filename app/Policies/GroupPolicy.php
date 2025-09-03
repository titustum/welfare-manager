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
        return true; // Allow listing groups (optional)
    }

    /**
     * Determine whether the user can view a group.
     */
    public function view(User $user, Group $group): bool
    {
        return true; // Allow viewing group details (optional)
    }

    /**
     * Determine whether the user can create a group.
     */
    public function create(User $user): bool
    {
        // return $user->role === 'admin';
        return true;
    }

    /**
     * Determine whether the user can update a group.
     */
    public function update(User $user, Group $group): bool
    {
        // return $user->role === 'admin';
        return true;
    }

    /**
     * Determine whether the user can delete a group.
     */
    public function delete(User $user, Group $group): bool
    {
        // return $user->role === 'admin';
        return true;
    }

    /**
     * Determine whether the user can restore a group.
     */
    public function restore(User $user, Group $group): bool
    {
        // return $user->role === 'admin';
        return true;
    }

    /**
     * Determine whether the user can permanently delete a group.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        // return $user->role === 'admin';
        return true;
    }
}
