<?php

namespace Nova\Themes\Policies;

use Nova\Users\Models\User;
use Nova\Themes\Models\Theme;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('theme.*');
    }

    public function view(User $user): bool
    {
        return $user->isAbleTo('theme.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('theme.create');
    }

    public function update(User $user): bool
    {
        return $user->isAbleTo('theme.update');
    }

    public function delete(User $user): bool
    {
        return $user->isAbleTo('theme.delete') && Theme::count() > 1;
    }

    public function restore(User $user, Theme $theme): bool
    {
        return false;
    }

    public function forceDelete(User $user, Theme $theme): bool
    {
        return false;
    }
}
