<?php

declare(strict_types=1);

namespace Nova\PostTypes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\PostTypes\Models\PostType;
use Nova\Users\Models\User;

class PostTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('story.*');
    }

    public function view(User $user, PostType $postType): bool
    {
        return $user->isAbleTo('story.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('story.create');
    }

    public function update(User $user, PostType $postType): bool
    {
        return $user->isAbleTo('story.update');
    }

    public function delete(User $user, PostType $postType): bool
    {
        return $user->isAbleTo('story.delete');
    }

    public function duplicate(User $user, PostType $postType): bool
    {
        return $user->isAbleTo('story.create')
            && $user->isAbleTo('story.update');
    }

    public function restore(User $user, PostType $postType): bool
    {
        return false;
    }

    public function forceDelete(User $user, PostType $postType): bool
    {
        return false;
    }

    public function write(User $user, PostType $postType): bool
    {
        if ($postType->role === null) {
            return true;
        }

        return $user->hasRole($postType->role->name);
    }
}
