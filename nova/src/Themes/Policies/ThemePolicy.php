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
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->can('theme.*');
    }

    /**
     * Determine whether the user can view the theme.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function view(User $user)
    {
        return $user->can('theme.view');
    }

    /**
     * Determine whether the user can create themes.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('theme.create');
    }

    /**
     * Determine whether the user can update the theme.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $user->can('theme.update');
    }

    /**
     * Determine whether the user can delete the theme.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->can('theme.delete');
    }

    /**
     * Determine whether the user can restore the theme.
     *
     * @param  User  $user
     * @param  Theme  $theme
     *
     * @return bool
     */
    public function restore(User $user, Theme $theme)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the theme.
     *
     * @param  User  $user
     * @param  Theme  $theme
     *
     * @return bool
     */
    public function forceDelete(User $user, Theme $theme)
    {
        return false;
    }
}
