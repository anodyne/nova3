<?php

declare(strict_types=1);

namespace Nova\PostTypes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\PostTypes\Models\PostType;
use Nova\Users\Models\User;

class PostTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('post-type.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, PostType $postType): Response
    {
        return $user->isAbleTo('post-type.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('post-type.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, PostType $postType): Response
    {
        return $user->isAbleTo('post-type.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('post-type.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, PostType $postType): Response
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, PostType $postType): Response
    {
        return $user->isAbleTo('post-type.create') && $user->isAbleTo('post-type.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, PostType $postType): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, PostType $postType): Response
    {
        return $this->denyWithStatus(418);
    }

    public function write(User $user, PostType $postType): Response
    {
        if ($postType->role === null) {
            return $this->allow();
        }

        return $user->hasRole($postType->role->name)
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}
