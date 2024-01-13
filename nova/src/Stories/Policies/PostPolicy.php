<?php

declare(strict_types=1);

namespace Nova\Stories\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\User;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('post.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Post $post): Response
    {
        return $user->isAbleTo('post.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('post.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Post $post): Response
    {
        if ($user->isAbleTo('post.update')) {
            return $this->allow();
        }

        $post->loadMissing('participatingUsers');

        if ($post->is_draft && $post->participatingUsers->contains('id', $user->id)) {
            return $this->allow();
        }

        if (
            $post->is_published &&
            $post->participatingUsers->contains('id', $user->id) &&
            $post->postType->options->editTimeframe !== PostEditTimeframe::never &&
            $post->published_at->copy()->add($post->postType->options->editTimeframe->value)->gte(now())
        ) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function delete(User $user, Post $post): Response
    {
        return $user->isAbleTo('post.delete') && $post->is_published
            ? $this->allow()
            : $this->deny();
    }

    public function discardDraft(User $user, Post $post): Response
    {
        if (! $post->exists) {
            return $this->deny();
        }

        if (
            $post?->is_draft &&
            ($post?->participatingUsers->contains('id', $user->id) || $user->isAbleTo('post.delete'))
        ) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function duplicate(User $user, Post $post): Response
    {
        return $user->isAbleTo('post.create') && $user->isAbleTo('post.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Post $post): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Post $post): Response
    {
        return $this->denyWithStatus(418);
    }

    public function write(User $user, Post $post, ?PostType $postType): Response
    {
        if ($postType === null || (isset($postType) && Gate::forUser($user)->allows('write', $postType))) {
            return $this->create($user, $post);
        }

        return $this->deny();
    }
}
