<?php

declare(strict_types=1);

namespace Nova\Addons\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Addons\Models\Addon;
use Nova\Users\Models\User;

class AddonPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('addon.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user): Response
    {
        return $user->isAbleTo('addon.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('addon.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Addon $addon): Response
    {
        return $user->isAbleTo('addon.update')
            ? $this->allow()
            : $this->deny();
    }

    public function updateSettings(User $user, Addon $addon): Response
    {
        return $this->update($user, $addon)->allowed() && $addon->settings?->hasSettings()
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Addon $addon): Response
    {
        return $user->isAbleTo('addon.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Addon $addon): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Addon $addon): Response
    {
        return $this->denyWithStatus(418);
    }

    public function runActions(User $user, Addon $addon): Response
    {
        $addonClass = $addon->getAddonClass();

        if (is_null($addonClass)) {
            return $this->deny();
        }

        return $this->update($user, $addon);
    }
}
