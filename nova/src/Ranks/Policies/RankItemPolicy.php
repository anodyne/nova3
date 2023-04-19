<?php

declare(strict_types=1);

namespace Nova\Ranks\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;

class RankItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any rank name.
     *
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->isAbleTo('rank.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can view the rank name.
     *
     *
     * @return bool
     */
    public function view(User $user, RankItem $name)
    {
        return $user->isAbleTo('rank.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can create rank names.
     *
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isAbleTo('rank.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can update the rank name.
     *
     *
     * @return bool
     */
    public function update(User $user, RankItem $name)
    {
        return $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the rank name.
     *
     *
     * @return bool
     */
    public function delete(User $user, RankItem $name)
    {
        return $user->isAbleTo('rank.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can duplicate the rank name.
     */
    public function duplicate(User $user, RankItem $name)
    {
        return $user->isAbleTo('rank.create') && $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the rank name.
     *
     *
     * @return bool
     */
    public function restore(User $user, RankItem $name)
    {
        return $this->denyWithStatus(418);
    }

    /**
     * Determine whether the user can permanently delete the rank name.
     *
     *
     * @return bool
     */
    public function forceDelete(User $user, RankItem $name)
    {
        return $this->denyWithStatus(418);
    }
}
