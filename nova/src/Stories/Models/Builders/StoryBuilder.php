<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Ongoing;
use Nova\Stories\Models\States\Upcoming;
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

    public function searchFor($value): self
    {
        return $this->where(function (Builder $query) use ($value): Builder {
            return $query->where('title', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%");
        });
    }

    public function upcoming(): self
    {
        return $this->whereState('status', Upcoming::class);
    }
}
