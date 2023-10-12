<?php

declare(strict_types=1);

namespace Nova\Posts\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Published;
use Nova\Posts\Models\States\Started;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class PostBuilder extends Builder
{
    public function searchFor($search): self
    {
        return $this->where(function ($query) use ($search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhere('day', 'like', "%{$search}%")
                ->orWhere('time', 'like', "%{$search}%");
        });
    }

    public function abandoned(): self
    {
        return $this->whereState('status', Started::class)
            ->where('created_at', '<', now()->subDays(2)->startOfDay());
    }

    public function whereHasUser(User $user): self
    {
        return $this->whereHas('userAuthors', fn (Builder $query) => $query->where('users.id', $user->id));
    }

    public function whereNotPost(Post $post): self
    {
        return $this->where('id', '!=', $post->id);
    }

    public function whereNotRootPost(): self
    {
        return $this->whereNotNull('parent_id');
    }

    public function wherePostType($postTypeId): self
    {
        return $this->where('post_type_id', $postTypeId);
    }

    public function whereDraft(): self
    {
        return $this->whereState('status', Draft::class);
    }

    public function published(): self
    {
        return $this->whereState('status', Published::class);
    }

    public function story(Story|int $story): self
    {
        $storyId = is_int($story) ? $story : $story->id;

        return $this->where('story_id', $storyId);
    }
}
