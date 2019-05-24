<?php

namespace Nova\Roles\Policies;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class RolePolicy
{
    /**
     * Determine if the current user can create a role.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('role.create');
    }

    /**
     * Determine if the current user can delete a role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return bool
     */
    public function delete(User $user, Role $role)
    {
        return $user->can('role.delete') && ! $role->locked;
    }

    /**
     * Determine if the current user can update a role.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Roles\Models\Role  $role
     *
     * @return bool
     */
    public function update(User $user, Role $role)
    {
        return $user->can('role.update') && ! $role->locked;
    }
}
