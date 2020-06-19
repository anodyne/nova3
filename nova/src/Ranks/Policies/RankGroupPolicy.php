<?php

namespace Nova\Ranks\Policies;

use Nova\Users\Models\User;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        return $user->can('rank.*');
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
        return $user->can('rank.view');
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
        return $user->can('rank.create');
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
        return $user->can('rank.update');
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
        return $user->can('rank.delete');
    }

    /**
     * Determine whether the user can duplicate the rank group.
     *
     * @param  User  $user
     * @param  RankGroup  $group
     */
    public function duplicate(User $user, RankGroup $group)
    {
        return $user->can('rank.create')
            && $user->can('rank.update');
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
        return false;
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
        return false;
    }
}
