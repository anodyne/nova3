<?php

namespace Nova\Themes\Policies;

use Nova\Users\Models\User;

class ThemePolicy
{
    /**
     * Determine if the current user can create a theme.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('theme.create');
    }

    /**
     * Determine if the current user can delete a theme.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->can('theme.delete');
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
        return $user->can('theme.update');
    }
}
