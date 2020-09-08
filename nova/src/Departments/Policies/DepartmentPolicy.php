<?php

namespace Nova\Departments\Policies;

use Nova\Users\Models\User;
use Nova\Departments\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('department.*');
    }

    public function view(User $user, Department $department): bool
    {
        return $user->isAbleTo('department.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('department.create');
    }

    public function update(User $user, Department $department): bool
    {
        return $user->isAbleTo('department.update');
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->isAbleTo('department.delete');
    }

    public function restore(User $user, Department $department): bool
    {
        return false;
    }

    public function forceDelete(User $user, Department $department): bool
    {
        return false;
    }
}
