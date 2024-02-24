<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\States\PostStatus\Started;
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

    public function currentMonth(): self
    {
        $startOfCurrentMonth = Date::now()->startOfMonth();
        $endOfCurrentMonth = Date::now()->endOfMonth();

        return $this->whereBetween('published_at', [$startOfCurrentMonth, $endOfCurrentMonth]);
    }

    public function currentYear(): self
    {
        $startOfCurrentYear = Date::now()->startOfYear();
        $endOfCurrentYear = Date::now()->endOfYear();

        return $this->whereBetween('published_at', [$startOfCurrentYear, $endOfCurrentYear]);
    }

    public function previousMonth(): self
    {
        $startOfPreviousMonth = Date::now()->subMonth()->startOfMonth();
        $endOfPreviousMonth = Date::now()->subMonth()->endOfMonth();

        return $this->whereBetween('published_at', [$startOfPreviousMonth, $endOfPreviousMonth]);
    }

    public function previousYear(): self
    {
        $startOfPreviousYear = Date::now()->subYear()->startOfYear();
        $endOfPreviousYear = Date::now()->subYear()->endOfYear();

        return $this->whereBetween('published_at', [$startOfPreviousYear, $endOfPreviousYear]);
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

    public function draft(): self
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
