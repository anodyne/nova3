<?php

namespace Nova\Themes\Policies;

use Nova\Users\Models\User;
use Nova\Themes\Models\Theme;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any theme.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('theme.*');
    }

    /**
     * Determine whether the user can view the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Themes\Models\Theme  $theme
     *
     * @return mixed
     */
    public function view(User $user, Theme $theme)
    {
        return $user->can('theme.*');
    }

    /**
     * Determine whether the user can create themes.
     *
     * @param  \Nova\Users\Models\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('theme.create');
    }

    /**
     * Determine whether the user can update the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Themes\Models\Theme  $theme
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->can('theme.update');
    }

    /**
     * Determine whether the user can delete the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Themes\Models\Theme  $theme
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('theme.delete');
    }

    /**
     * Determine whether the user can restore the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Themes\Models\Theme  $theme
     *
     * @return mixed
     */
    public function restore(User $user, Theme $theme)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the theme.
     *
     * @param  \Nova\Users\Models\User  $user
     * @param  \Nova\Themes\Models\Theme  $theme
     *
     * @return mixed
     */
    public function forceDelete(User $user, Theme $theme)
    {
        return false;
    }
}
