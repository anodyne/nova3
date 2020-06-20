<?php

namespace Nova\Ranks\Policies;

use Nova\Users\Models\User;
use Nova\Ranks\Models\RankItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any rank name.
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
     * Determine whether the user can view the rank name.
     *
     * @param  User  $user
     * @param  RankItem  $name
     *
     * @return bool
     */
    public function view(User $user, RankItem $name)
    {
        return $user->can('rank.view');
    }

    /**
     * Determine whether the user can create rank names.
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
     * Determine whether the user can update the rank name.
     *
     * @param  User  $user
     * @param  RankItem  $name
     *
     * @return bool
     */
    public function update(User $user, RankItem $name)
    {
        return $user->can('rank.update');
    }

    /**
     * Determine whether the user can delete the rank name.
     *
     * @param  User  $user
     * @param  RankItem  $name
     *
     * @return bool
     */
    public function delete(User $user, RankItem $name)
    {
        return $user->can('rank.delete');
    }

    /**
     * Determine whether the user can duplicate the rank name.
     *
     * @param  User  $user
     * @param  RankItem  $name
     */
    public function duplicate(User $user, RankItem $name)
    {
        return $user->can('rank.create')
            && $user->can('rank.update');
    }

    /**
     * Determine whether the user can restore the rank name.
     *
     * @param  User  $user
     * @param  RankItem  $name
     *
     * @return bool
     */
    public function restore(User $user, RankItem $name)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the rank name.
     *
     * @param  User  $user
     * @param  RankItem  $name
     *
     * @return bool
     */
    public function forceDelete(User $user, RankItem $name)
    {
        return false;
    }
}
