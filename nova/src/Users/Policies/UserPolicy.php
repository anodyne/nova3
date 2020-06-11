<?php

namespace Nova\Users\Policies;

use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any user.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('user.*');
    }

    /**
     * Determine whether the user can view the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Users\Models\User  $actionableUser
     *
     * @return mixed
     */
    public function view(User $user, User $actionableUser)
    {
        return $user->can('user.view');
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('user.create');
    }

    /**
     * Determine whether the user can update the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Users\Models\User  $actionableUser
     *
     * @return mixed
     */
    public function update(User $user, User $actionableUser)
    {
        return $user->can('user.update');
    }

    /**
     * Determine whether the user can delete the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Users\Models\User  $actionableUser
     *
     * @return mixed
     */
    public function delete(User $user, User $actionableUser)
    {
        return $user->can('user.delete') && $user->isNot($actionableUser);
    }

    /**
     * Determine whether the user can restore the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Users\Models\User  $actionableUser
     *
     * @return mixed
     */
    public function restore(User $user, User $actionableUser)
    {
        return $user->can('user.create') || $user->can('user.delete');
    }

    /**
     * Determine whether the user can permanently delete the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Users\Models\User  $actionableUser
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $actionableUser)
    {
        return $this->delete($user, $actionableUser);
    }
}
