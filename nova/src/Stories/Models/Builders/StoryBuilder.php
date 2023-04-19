<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Ongoing;
use Nova\Stories\Models\States\Upcoming;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;

class StoryBuilder extends Builder
{
    use Filterable;

    public function searchFor($value): self
    {
        return $this->where('title', 'like', "%{$value}%");
    }

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

    public function parent($parent = null): self
    {
        return $this->where('parent_id', $parent);
    }

    public function upcoming(): self
    {
        return $this->whereState('status', Upcoming::class);
    }

    public function notUpcoming(): self
    {
        return $this->whereNotState('status', Upcoming::class);
    }
}
