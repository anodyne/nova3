<?php

declare(strict_types=1);

namespace Nova\Posts\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Published;
use Nova\Posts\Models\States\Started;

class PostBuilder extends Builder
{
    use Filterable;
    use Sortable;

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

    public function wherePublished(): self
    {
        return $this->whereState('status', Published::class);
    }

    public function story($storyId): self
    {
        return $this->where('story_id', $storyId);
    }
}
