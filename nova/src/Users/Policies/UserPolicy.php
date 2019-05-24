<?php

namespace Nova\Users\Policies;

use Nova\Users\Models\User;

class UserPolicy
{
    /**
     * Determine if the current user can create a user.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('user.create');
    }

    /**
     * Determine if the current user can delete the user.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Users\Models\User  $actionUser
     *
     * @return bool
     */
    public function delete(User $user, User $actionUser)
    {
        return $user->can('user.delete') && $user->isNot($actionUser);
    }

    /**
     * Determine if the current user can update a theme.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $user->can('user.update');
    }
}
