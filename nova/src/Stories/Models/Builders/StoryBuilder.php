<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Kalnoy\Nestedset\QueryBuilder;
use Nova\Foundation\Filters\Filterable;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;

class StoryBuilder extends QueryBuilder
{
    use Filterable;

    public function whereCurrent(): self
    {
        return $this->where('status', Current::class);
    }

    public function whereMainTimeline(): self
    {
        return $this->where('id', 1);
    }

    public function whereParent($parent = null): self
    {
        return $this->where('parent_id', $parent);
    }

    public function wherePostable(): self
    {
        return $this->where(
            fn (Builder $query) => $query->whereCurrent()->where('allow_posting', true)
        );
    }

    public function whereUpcoming(): self
    {
        return $this->where('status', Upcoming::class);
    }
}
