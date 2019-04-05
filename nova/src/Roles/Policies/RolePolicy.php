<?php

namespace Nova\Roles\Policies;

use Nova\Users\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create Roles.
     *
     * @param  \Nova\Users\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('role.create');
    }

    /**
     * Determine whether the user can update the Role.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Silber\Bouncer\Database\Role  $role
     *
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->can('role.update');
    }

    /**
     * Determine whether the user can delete the Role.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Silber\Bouncer\Database\Role  $role
     *
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->can('role.delete');
    }

    /**
     * Determine whether the user can manage the Role.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Silber\Bouncer\Database\Role  $role
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        $role = new Role;

        return $this->create($user)
            or $this->update($user, $role)
            or $this->delete($user, $role);
    }
}
