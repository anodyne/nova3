<?php

namespace Nova\Departments\Policies;

use Nova\Users\Models\User;
use Nova\Departments\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any department.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->can('department.*');
    }

    /**
     * Determine whether the user can view the department.
     *
     * @param  User  $user
     * @param  Department  $department
     *
     * @return bool
     */
    public function view(User $user, Department $department)
    {
        return $user->can('department.view');
    }

    /**
     * Determine whether the user can create departments.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('department.create');
    }

    /**
     * Determine whether the user can update the department.
     *
     * @param  User  $user
     * @param  Department  $department
     *
     * @return bool
     */
    public function update(User $user, Department $department)
    {
        return $user->can('department.update');
    }

    /**
     * Determine whether the user can delete the department.
     *
     * @param  User  $user
     * @param  Department  $department
     *
     * @return bool
     */
    public function delete(User $user, Department $department)
    {
        return $user->can('department.delete');
    }

    /**
     * Determine whether the user can restore the department.
     *
     * @param  User  $user
     * @param  Department  $department
     *
     * @return bool
     */
    public function restore(User $user, Department $department)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the department.
     *
     * @param  User  $user
     * @param  Department  $department
     *
     * @return bool
     */
    public function forceDelete(User $user, Department $department)
    {
        return false;
    }
}
