<?php

declare(strict_types=1);

namespace Nova\Menus\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Menus\Models\Menu;
use Nova\Users\Models\User;

class MenuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('menu.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Menu $menu): Response
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

    public function update(User $user, Menu $menu): Response
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

    public function delete(User $user, Menu $menu): Response
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, Menu $menu): Response
    {
        return $user->isAbleTo('menu.create') && $user->isAbleTo('menu.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Menu $menu): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Menu $menu): Response
    {
        return $this->denyWithStatus(418);
    }
}
