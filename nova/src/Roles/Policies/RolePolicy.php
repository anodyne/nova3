<?php

namespace Nova\Roles\Policies;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('role.*');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->isAbleTo('role.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('role.create');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->isAbleTo('role.update');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->isAbleTo('role.delete') && ! $role->locked;
    }

    public function duplicate(User $user, Role $role): bool
    {
        return $user->isAbleTo('role.create')
            && $user->isAbleTo('role.update')
            && ! $role->locked;
    }

    public function restore(User $user, Role $role): bool
    {
        return false;
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }
}
