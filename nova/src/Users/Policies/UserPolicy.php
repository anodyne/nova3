<?php

declare(strict_types=1);

namespace Nova\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any user.
     *
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAbleTo('user.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can view the theme.
     *
     *
     * @return mixed
     */
    public function view(User $user, User $actionableUser)
    {
        return $user->isAbleTo('user.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can create users.
     *
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAbleTo('user.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can update the theme.
     *
     *
     * @return mixed
     */
    public function update(User $user, User $actionableUser)
    {
        return $user->isAbleTo('user.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the theme.
     *
     *
     * @return mixed
     */
    public function delete(User $user, User $actionableUser)
    {
        return $user->isAbleTo('user.delete') && $user->isNot($actionableUser)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, User $actionableUser)
    {
        return $user->isAbleTo('user.create') || $user->isAbleTo('user.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function forceDelete(User $user, User $actionableUser)
    {
        return $this->delete($user, $actionableUser);
    }

    public function activate(User $user, User $actionableUser)
    {
        return $this->update($user, $actionableUser) && $actionableUser->status->equals(Inactive::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deactivate(User $user, User $actionableUser)
    {
        return $this->update($user, $actionableUser) && $actionableUser->status->equals(Active::class) && $actionableUser->isNot($user)
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function forcePasswordReset(User $user, User $actionableUser)
    {
        return $this->update($user, $actionableUser) && ! $actionableUser->status->equals(Pending::class)
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}
