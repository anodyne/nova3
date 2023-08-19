<?php

declare(strict_types=1);

namespace Nova\Ranks\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Ranks\Models\RankName;
use Nova\Users\Models\User;

class RankNamePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('rank.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, RankName $name): Response
    {
        return $user->isAbleTo('rank.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('rank.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, RankName $name): Response
    {
        return $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('rank.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, RankName $name): Response
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, RankName $name): Response
    {
        return $user->isAbleTo('rank.create') && $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, RankName $name): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, RankName $name): Response
    {
        return $this->denyWithStatus(418);
    }
}
