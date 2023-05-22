<?php

declare(strict_types=1);

namespace Nova\Departments\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Departments\Models\Department;
use Nova\Users\Models\User;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('department.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Department $department): Response
    {
        return $user->isAbleTo('department.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('department.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Department $department): Response
    {
        return $user->isAbleTo('department.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('department.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Department $department): Response
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, Department $department): Response
    {
        return $user->isAbleTo('department.create') && $user->isAbleTo('department.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Department $department): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Department $department): Response
    {
        return $this->denyWithStatus(418);
    }
}
