<?php

namespace Nova\Departments\Policies;

use Nova\Users\Models\User;
use Nova\Departments\Models\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('department.*');
    }

    public function view(User $user, Position $position): bool
    {
        return $user->isAbleTo('department.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('department.create');
    }

    public function update(User $user, Position $position): bool
    {
        return $user->isAbleTo('department.update');
    }

    public function delete(User $user, Position $position): bool
    {
        return $user->isAbleTo('department.delete');
    }

    public function restore(User $user, Position $position): bool
    {
        return false;
    }

    public function forceDelete(User $user, Position $position): bool
    {
        return false;
    }
}
