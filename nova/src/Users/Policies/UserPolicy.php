<?php

namespace Nova\Users\Policies;

use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;

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

    public function restore(User $user, User $actionableUser)
    {
        return $user->can('user.create') || $user->can('user.delete');
    }

    public function forceDelete(User $user, User $actionableUser)
    {
        return $this->delete($user, $actionableUser);
    }

    public function activate(User $user, User $actionableUser)
    {
        return $this->update($user, $actionableUser)
            && $actionableUser->status->equals(Inactive::class);
    }

    public function deactivate(User $user, User $actionableUser)
    {
        return $this->update($user, $actionableUser)
            && $actionableUser->status->equals(Active::class)
            && $actionableUser->isNot($user);
    }

    public function forcePasswordReset(User $user, User $actionableUser)
    {
        return $this->update($user, $actionableUser)
            && ! $actionableUser->status->equals(Pending::class);
    }
}
