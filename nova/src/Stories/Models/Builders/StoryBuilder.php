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
}
