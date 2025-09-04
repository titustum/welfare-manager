<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use Illuminate\Auth\Access\Response;
use Filament\Facades\Filament;

class UserPolicy
{
    /**
     * Allow viewing user lists (in the current tenant/group context).
     */
    public function viewAny(User $user): bool
    {
        return true; // Already tenant scoped by Filament
    }

    /**
     * Allow viewing a specific user.
     */
    public function view(User $user, User $model): bool
    {
        // Allow if they share at least one group
        return $user->groups->pluck('id')->intersect(
            $model->groups->pluck('id')
        )->isNotEmpty();
    }

    /**
     * Can create a user in a group (add member to group).
     */
    public function create(User $user): bool
    {
        $group = Filament::getTenant();

        if (!$group) {
            return false;
        }

        return $user->hasRoleInGroup($group->id, ['chair', 'secretary']);
    }
    /**
     * Can update another user's details (likely not needed unless editing profile).
     */
    public function update(User $user, User $model): bool
    {
        // Only allow if same group and acting user is chair or secretary
        $groupId = Filament::getTenant()?->id;

        if (!$groupId) return false;

        return $user->hasRoleInGroup($groupId, ['chair', 'secretary']) &&
            $model->groups->contains($groupId);
    }

    /**
     * Can remove a user from the group.
     */
    public function delete(User $user, User $model): bool
    {
        $groupId = Filament::getTenant()?->id;

        if (!$groupId) return false;

        return $user->hasRoleInGroup($groupId, ['chair', 'secretary']) &&
            $model->groups->contains($groupId);
    }

    /**
     * Disallow restoring users (optional).
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Disallow force deleting users.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
