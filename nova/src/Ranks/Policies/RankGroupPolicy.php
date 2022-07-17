<?php

declare(strict_types=1);

namespace Nova\Ranks\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Ranks\Models\RankGroup;
use Nova\Users\Models\User;

class RankGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any rank group.
     *
     * @param  User  $user
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
     * Determine whether the user can view the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     *
     * @return bool
     */
    public function view(User $user, RankGroup $group)
    {
        return $user->isAbleTo('rank.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can create rank groups.
     *
     * @param  User  $user
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
     * Determine whether the user can update the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     *
     * @return bool
     */
    public function update(User $user, RankGroup $group)
    {
        return $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     *
     * @return bool
     */
    public function delete(User $user, RankGroup $group)
    {
        return $user->isAbleTo('rank.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can duplicate the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     */
    public function duplicate(User $user, RankGroup $group)
    {
        return $user->isAbleTo('rank.create') && $user->isAbleTo('rank.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     *
     * @return bool
     */
    public function restore(User $user, RankGroup $group)
    {
        return $this->denyWithStatus(418);
    }

    /**
     * Determine whether the user can permanently delete the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     *
     * @return bool
     */
    public function forceDelete(User $user, RankGroup $group)
    {
        return $this->denyWithStatus(418);
    }
}
