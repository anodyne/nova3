<?php

namespace Nova\Stories\Policies;

use Nova\Users\Models\User;
use Nova\Stories\Models\PostType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('story.*');
    }

    public function view(User $user, PostType $postType): bool
    {
        return $user->can('story.view');
    }

    public function create(User $user): bool
    {
        return $user->can('story.create');
    }

    public function update(User $user, PostType $postType): bool
    {
        return $user->can('story.update');
    }

    public function delete(User $user, PostType $postType): bool
    {
        return $user->can('story.delete');
    }

    public function duplicate(User $user, PostType $postType): bool
    {
        return $user->can('story.create')
            && $user->can('story.update');
    }

    public function restore(User $user, PostType $postType): bool
    {
        return false;
    }

    public function forceDelete(User $user, PostType $postType): bool
    {
        return false;
    }
}
