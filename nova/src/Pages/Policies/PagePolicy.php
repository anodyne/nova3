<?php

declare(strict_types=1);

namespace Nova\Pages\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Pages\Models\Page;
use Nova\Users\Models\User;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('page.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Page $page): Response
    {
        return $user->isAbleTo('page.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('page.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Page $page): Response
    {
        return $user->isAbleTo('page.update')
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('page.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Page $page): Response
    {
        return $this->deleteAny($user)->allowed()
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, Page $page): Response
    {
        return $user->isAbleTo('page.create') && $user->isAbleTo('page.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Page $page): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Page $page): Response
    {
        return $this->denyWithStatus(418);
    }

    public function design(User $user, Page $page): Response
    {
        return $this->update($user, $page)->allowed() && $page->is_basic
            ? $this->allow()
            : $this->deny();
    }
}
