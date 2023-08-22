<?php

declare(strict_types=1);

namespace Nova\Roles\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('role.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Role $role): Response
    {
        return $user->isAbleTo('role.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('role.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Role $role): Response
    {
        return $user->isAbleTo('role.update')
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('role.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Role $role): Response
    {
        return $user->isAbleTo('role.delete') && ! $role->locked
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, Role $role): Response
    {
        return $user->isAbleTo('role.create') && $user->isAbleTo('role.update') && ! $role->locked
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Role $role): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Role $role): Response
    {
        return $this->denyWithStatus(418);
    }
}
