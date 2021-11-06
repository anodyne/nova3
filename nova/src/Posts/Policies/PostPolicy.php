<?php

declare(strict_types=1);

namespace Nova\Posts\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

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
        return $user->isAbleTo('post.create')
            && Story::whereCurrent()->count() > 0;
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAbleTo('post.update');
    }

    public function delete(User $user, Post $post): bool
    {
        if ($post->status->equals(Draft::class)) {
            return true;
        }

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

    public function write(User $user, Post $post, ?PostType $postType): bool
    {
        if ($postType === null || (isset($postType) && Gate::forUser($user)->allows('write', $postType))) {
            return $this->create($user, $post);
        }

        return false;
    }
}
