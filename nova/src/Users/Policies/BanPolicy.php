<?php

declare(strict_types=1);

namespace Nova\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;

class BanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('ban.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Ban $ban): Response
    {
        return $user->isAbleTo('ban.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('ban.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Ban $ban): Response
    {
        return $user->isAbleTo('ban.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Ban $ban): Response
    {
        return $this->deleteAny($user);
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('ban.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Ban $ban): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Ban $ban): Response
    {
        return $this->denyWithStatus(418);
    }
}
