<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Ongoing;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;

class StoryBuilder extends Builder
{
    public function completed(): self
    {
        return $this->whereState('status', Completed::class);
    }

    public function current(): self
    {
        return $this->whereState('status', Current::class);
    }

    public function ongoing(): self
    {
        return $this->whereState('status', Ongoing::class);
    }

    public function parent(Story|int|null $parent): self
    {
        return $this
            ->when(is_int($parent), fn (Builder $query): Builder => $query->where('parent_id', $parent))
            ->unless(is_int($parent), fn (Builder $query): Builder => $query->where('parent_id', $parent?->id));
    }

    public function searchFor($search): self
    {
        return $this->whereAny([
            'title',
            'description',
        ], 'like', "%{$search}%");
    }

    public function upcoming(): self
    {
        return $this->whereState('status', Upcoming::class);
    }

    public function exceptUpcoming(): self
    {
        return $this->whereNotState('status', Upcoming::class);
    }

    public function withCountsAndSums(): self
    {
        if (app('nova.environment')->database->isMysql()) {
            return $this
                ->withCount('posts', 'recursivePosts', 'children')
                ->withSum(['recursivePosts', 'posts'], 'word_count');
        }

        return $this
            ->withCount('posts', 'children')
            ->withSum('posts', 'word_count');
    }

    public function selectTotalCount(): self
    {
        return $this->selectRaw('COUNT(*) as total_count');
    }

    public function selectStatusCounts(): self
    {
        return $this
            ->selectRaw("
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = 'current' THEN 1 ELSE 0 END) as current_count,
                SUM(CASE WHEN status = 'ongoing' THEN 1 ELSE 0 END) as ongoing_count,
                SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming_count
            ");
    }
}
