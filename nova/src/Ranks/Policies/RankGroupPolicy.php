<?php

declare(strict_types=1);

namespace Nova\Ranks\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Ranks\Models\RankGroup;
use Nova\Users\Models\User;

class RankGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('rank.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, RankGroup $group): Response
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

    public function update(User $user, RankGroup $group): Response
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

    public function delete(User $user, RankGroup $group): Response
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, RankGroup $group): Response
    {
        return $user->isAbleTo('rank.create') && $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, RankGroup $group): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, RankGroup $group): Response
    {
        return $this->denyWithStatus(418);
    }
}
