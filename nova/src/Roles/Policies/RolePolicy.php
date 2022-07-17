<?php

declare(strict_types=1);

namespace Nova\Roles\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAbleTo('role.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Role $role)
    {
        return $user->isAbleTo('role.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('role.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Role $role)
    {
        return $user->isAbleTo('role.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Role $role)
    {
        return $user->isAbleTo('role.delete') && ! $role->locked
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, Role $role)
    {
        return $user->isAbleTo('role.create') && $user->isAbleTo('role.update') && ! $role->locked
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Role $role)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Role $role)
    {
        return $this->denyWithStatus(418);
    }
}
