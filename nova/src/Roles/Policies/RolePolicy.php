<?php

namespace Nova\Roles\Policies;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any role.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('role.create') ||
            $user->can('role.delete') ||
            $user->can('role.update');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return true;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('role.create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->can('role.update') && ! $role->locked;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->can('role.delete') && ! $role->locked;
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        return false;
    }
}
