<?php

declare(strict_types=1);

namespace Nova\Settings\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Settings\Models\Settings;
use Nova\Users\Models\User;

class SettingsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('settings.*');
    }

    public function view(User $user, Settings $settings): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Settings $settings): bool
    {
        return $user->isAbleTo('settings.update');
    }

    public function delete(User $user, Settings $settings): bool
    {
        return false;
    }

    public function duplicate(User $user, Settings $settings): bool
    {
        return false;
    }

    public function restore(User $user, Settings $settings): bool
    {
        return false;
    }

    public function forceDelete(User $user, Settings $settings): bool
    {
        return false;
    }
}
