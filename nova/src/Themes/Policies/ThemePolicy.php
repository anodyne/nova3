<?php

declare(strict_types=1);

namespace Nova\Themes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Themes\Models\Theme;
use Nova\Users\Models\User;

class ThemePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('theme.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user): Response
    {
        return $user->isAbleTo('theme.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('theme.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user): Response
    {
        return $user->isAbleTo('theme.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Theme $theme): Response
    {
        return $user->isAbleTo('theme.delete') && Theme::count() > 1 && settings('appearance.theme') !== $theme->location
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Theme $theme): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Theme $theme): Response
    {
        return $this->denyWithStatus(418);
    }
}
