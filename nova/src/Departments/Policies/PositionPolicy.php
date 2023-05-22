<?php

declare(strict_types=1);

namespace Nova\Departments\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

class PositionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAbleTo('department.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Position $position)
    {
        return $user->isAbleTo('department.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('department.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Position $position)
    {
        return $user->isAbleTo('department.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deleteAny(User $user)
    {
        return $user->isAbleTo('department.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Position $position)
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, Position $position)
    {
        return $user->isAbleTo('department.create') && $user->isAbleTo('department.update')
            ? $this->allow()
            : $this->denyAsNotFound();
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
