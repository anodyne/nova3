<?php

namespace Nova\Themes\Policies;

use Nova\Users\User;
use Nova\Themes\Theme;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     * @return mixed
     */
    public function view(User $user, Theme $theme)
    {
        //
    }

    /**
     * Determine whether the user can create themes.
     *
     * @param  \Nova\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     * @return mixed
     */
    public function update(User $user, Theme $theme)
    {
        //
    }

    /**
     * Determine whether the user can delete the theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     * @return mixed
     */
    public function delete(User $user, Theme $theme)
    {
        //
    }

    /**
     * Determine whether the user can restore the theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     * @return mixed
     */
    public function restore(User $user, Theme $theme)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the theme.
     *
     * @param  \Nova\Users\User  $user
     * @param  \Nova\Themes\Theme  $theme
     * @return mixed
     */
    public function forceDelete(User $user, Theme $theme)
    {
        //
    }
}
