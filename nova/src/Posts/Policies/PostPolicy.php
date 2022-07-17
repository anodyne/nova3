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

    public function viewAny(User $user)
    {
        return $user->isAbleTo('post.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Post $post)
    {
        return $user->isAbleTo('post.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('post.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Post $post)
    {
        return $user->isAbleTo('post.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Post $post)
    {
        if (! $post->exists) {
            return false;
        }

        if ($post?->status->equals(Draft::class)) {
            // TODO: need to make sure the user is an author on the post
            return true;
        }

        return $user->isAbleTo('post.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, Post $post)
    {
        return $user->isAbleTo('post.create') && $user->isAbleTo('post.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Post $post)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Post $post)
    {
        return $this->denyWithStatus(418);
    }

    public function write(User $user, Post $post, ?PostType $postType)
    {
        if ($postType === null || (isset($postType) && Gate::forUser($user)->allows('write', $postType))) {
            return $this->create($user, $post);
        }

        return $this->denyAsNotFound();
    }
}
