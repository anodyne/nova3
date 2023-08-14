<?php

declare(strict_types=1);

namespace Nova\Roles\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Roles\Models\Permission;
use Nova\Users\Models\User;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('role.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Permission $permission): Response
    {
        return $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->deny();
    }

    public function update(User $user, Permission $permission): Response
    {
        return $this->deny();
    }

    public function delete(User $user, Permission $permission): Response
    {
        return $this->deny();
    }

    public function restore(User $user, Permission $permission): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Permission $permission): Response
    {
        return $this->denyWithStatus(418);
    }
}
