<?php

declare(strict_types=1);

namespace Nova\Settings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Settings\Models\Settings;
use Nova\Users\Models\User;

class SettingsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAbleTo('settings.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Settings $settings)
    {
        return $user->isAbleTo('settings.*')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user)
    {
        return $this->deny();
    }

    public function update(User $user, Settings $settings)
    {
        return $user->isAbleTo('settings.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Settings $settings)
    {
        return $this->deny();
    }

    public function duplicate(User $user, Settings $settings)
    {
        return $this->deny();
    }

    public function restore(User $user, Settings $settings)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Settings $settings)
    {
        return $this->denyWithStatus(418);
    }
}
