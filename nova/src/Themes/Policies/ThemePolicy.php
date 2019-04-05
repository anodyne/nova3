<?php

namespace Nova\Themes\Policies;

use Nova\Users\User;
use Nova\Themes\Theme;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a theme.
     *
     * @param  \Nova\Users\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('theme.create');
    }

    /**
     * Determine whether the user can update a theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     *
     * @return mixed
     */
    public function update(User $user, Theme $theme)
    {
        return $user->can('theme.update');
    }

    /**
     * Determine whether the user can delete a theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     *
     * @return mixed
     */
    public function delete(User $user, Theme $theme)
    {
        return $user->can('theme.delete');
    }

    /**
     * Determine whether the user can manage themes.
     *
     * @param  \Nova\Users\User  $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        $theme = new Theme;

        return $this->create($user)
            or $this->update($user, $theme)
            or $this->delete($user, $theme);
    }
}
