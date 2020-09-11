<?php

namespace Nova\Posts\Policies;

use Nova\Posts\Models\Post;
use Nova\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;
use Nova\PostTypes\Models\PostType;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('post.*');
    }

    public function view(User $user, Post $post): bool
    {
        return $user->isAbleTo('post.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('post.create');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAbleTo('post.update');
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->isAbleTo('post.delete');
    }

    public function duplicate(User $user, Post $post): bool
    {
        return $user->isAbleTo('post.create')
            && $user->isAbleTo('post.update');
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }

    public function write(User $user, Post $post, PostType $postType): bool
    {
        return $this->create($user, $post)
            && Gate::forUser($user)->allows('write', $postType);
    }
}
