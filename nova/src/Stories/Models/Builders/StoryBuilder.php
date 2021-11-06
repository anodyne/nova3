<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Kalnoy\Nestedset\QueryBuilder;
use Nova\Foundation\Filters\Filterable;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Ongoing;
use Nova\Stories\Models\States\Upcoming;

class StoryBuilder extends QueryBuilder
{
    use Filterable;

    public function whereCompleted(): self
    {
        return $this->whereState('status', Completed::class);
    }

    public function whereCurrent(): self
    {
        return $this->whereState('status', Current::class);
    }

    public function whereMainTimeline(): self
    {
        return $this->where('id', 1);
    }

    public function whereOngoing(): self
    {
        return $this->whereState('status', Ongoing::class);
    }

    public function whereParent($parent = null): self
    {
        return $this->where('parent_id', $parent);
    }

    public function whereUpcoming(): self
    {
        return $this->whereState('status', Upcoming::class);
    }

    public function whereNotUpcoming(): self
    {
        return $this->whereNotState('status', Upcoming::class);
    }
}
