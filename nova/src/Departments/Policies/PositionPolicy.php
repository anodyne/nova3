<?php

declare(strict_types=1);

namespace Nova\Departments\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

class PositionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('department.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Position $position)
    {
        return $user->isAbleTo('department.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('department.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Position $position)
    {
        return $user->isAbleTo('department.update')
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user)
    {
        return $user->isAbleTo('department.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Position $position)
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, Position $position)
    {
        return $user->isAbleTo('department.create') && $user->isAbleTo('department.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Position $position)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Position $position)
    {
        return $this->denyWithStatus(418);
    }
}
