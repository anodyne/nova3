<?php

declare(strict_types=1);

namespace Nova\Stories\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\User;

class PostTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('post-type.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, PostType $postType): Response
    {
        return $user->isAbleTo('post-type.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('post-type.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, PostType $postType): Response
    {
        return $user->isAbleTo('post-type.update')
            ? $this->allow()
            : $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('post-type.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, PostType $postType): Response
    {
        return $this->deleteAny($user)->allowed() && ! $postType->trashed()
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, PostType $postType): Response
    {
        return $user->isAbleTo('post-type.create') && $user->isAbleTo('post-type.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restoreAny(User $user): Response
    {
        return $user->isAbleTo('post-type.restore')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, PostType $postType): Response
    {
        return $this->restoreAny($user)->allowed() && $postType->trashed()
            ? $this->allow()
            : $this->deny();
    }

    public function forceDelete(User $user, PostType $postType): Response
    {
        return $this->deleteAny($user)->allowed() && $postType->trashed()
            ? $this->allow()
            : $this->deny();
    }

    public function write(User $user, PostType $postType): Response
    {
        if ($postType->role === null) {
            return $this->allow();
        }

        return $user->hasRole($postType->role->name)
            ? $this->allow()
            : $this->deny();
    }
}
