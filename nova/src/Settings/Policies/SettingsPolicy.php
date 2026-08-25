<?php

declare(strict_types=1);

namespace Nova\Settings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Settings\Models\Settings;
use Nova\Users\Models\User;

class SettingsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('settings.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Settings $settings): Response
    {
        return $user->isAbleTo('settings.*')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->deny();
    }

    public function update(User $user, Settings $settings): Response
    {
        return $user->isAbleTo('settings.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Settings $settings): Response
    {
        return $this->deny();
    }

    public function duplicate(User $user, Settings $settings): Response
    {
        return $this->deny();
    }

    public function restore(User $user, Settings $settings): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Settings $settings): Response
    {
        return $this->denyWithStatus(418);
    }
}
