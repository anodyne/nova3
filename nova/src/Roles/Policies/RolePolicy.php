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
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->can('role.*');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  User  $user
     * @param  Role  $role
     *
     * @return bool
     */
    public function view(User $user, Role $role)
    {
        return $user->can('role.view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('role.create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  User  $user
     * @param  Role  $role
     *
     * @return bool
     */
    public function update(User $user, Role $role)
    {
        return $user->can('role.update') && ! $role->locked;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  User  $user
     * @param  Role  $role
     *
     * @return bool
     */
    public function delete(User $user, Role $role)
    {
        return $user->can('role.delete') && ! $role->locked;
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  User  $user
     * @param  Role  $role
     *
     * @return bool
     */
    public function restore(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  User  $user
     * @param  Role  $role
     *
     * @return bool
     */
    public function forceDelete(User $user, Role $role)
    {
        return false;
    }
}
