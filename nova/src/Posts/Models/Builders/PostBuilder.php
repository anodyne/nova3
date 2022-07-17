<?php

declare(strict_types=1);

namespace Nova\Posts\Models\Builders;

use Kalnoy\Nestedset\QueryBuilder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Published;

class PostBuilder extends QueryBuilder
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

    public function whereStory($storyId): self
    {
        return $this->where('story_id', $storyId);
    }
}
