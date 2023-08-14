<?php

declare(strict_types=1);

namespace Nova\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('user.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, User $actionableUser): Response
    {
        return $user->isAbleTo('user.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('user.create')
            ? $this->allow()
            : $this->deny();
    }

    public function updateAny(User $user): Response
    {
        return $user->isAbleTo('user.update')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, User $actionableUser): Response
    {
        return $user->isAbleTo('user.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, User $actionableUser): Response
    {
        return $user->isAbleTo('user.delete') && $user->isNot($actionableUser)
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, User $actionableUser): Response
    {
        return $user->isAbleTo('user.create') || $user->isAbleTo('user.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function forceDelete(User $user, User $actionableUser): Response
    {
        return $this->delete($user, $actionableUser);
    }

    public function activate(User $user, User $actionableUser): Response
    {
        return $this->update($user, $actionableUser) && $actionableUser->status->equals(Inactive::class)
            ? $this->allow()
            : $this->deny();
    }

    public function deactivate(User $user, User $actionableUser): Response
    {
        return $this->update($user, $actionableUser) && $actionableUser->status->equals(Active::class) && $actionableUser->isNot($user)
            ? $this->allow()
            : $this->deny();
    }

    public function forcePasswordReset(User $user, User $actionableUser): Response
    {
        return $this->update($user, $actionableUser) && ! $actionableUser->status->equals(Pending::class)
            ? $this->allow()
            : $this->deny();
    }

    public function impersonate(User $user, User $actionableUser): Response
    {
        return $user->isAbleTo('user.impersonate') && $user->isNot($actionableUser)
            ? $this->allow()
            : $this->deny();
    }
}
