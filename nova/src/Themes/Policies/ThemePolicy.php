<?php

declare(strict_types=1);

namespace Nova\Themes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Themes\Models\Theme;
use Nova\Users\Models\User;

class ThemePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAbleTo('theme.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user)
    {
        return $user->isAbleTo('theme.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('theme.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user)
    {
        return $user->isAbleTo('theme.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user)
    {
        return $user->isAbleTo('theme.delete') && Theme::count() > 1
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Theme $theme)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Theme $theme)
    {
        return $this->denyWithStatus(418);
    }
}
