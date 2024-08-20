<?php

declare(strict_types=1);

namespace Nova\Menus\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Menus\Models\MenuItem;
use Nova\Users\Models\User;

class MenuItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('menu.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, MenuItem $menuItem): Response
    {
        return $user->isAbleTo('menu.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('menu.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, MenuItem $menuItem): Response
    {
        return $user->isAbleTo('menu.update')
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('menu.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, MenuItem $menuItem): Response
    {
        return $this->deleteAny($user);
    }

    public function restore(User $user, MenuItem $menuItem): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, MenuItem $menuItem): Response
    {
        return $this->denyWithStatus(418);
    }
}
