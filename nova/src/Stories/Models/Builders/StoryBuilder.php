<?php

namespace Nova\Stories\Models\Builders;

use Kalnoy\Nestedset\QueryBuilder;
use Nova\Foundation\Filters\Filterable;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;

class StoryBuilder extends QueryBuilder
{
    use Filterable;

    public function whereCurrent()
    {
        return $this->where('status', Current::class);
    }

    public function whereUpcoming()
    {
        return $this->where('status', Upcoming::class);
    }
}
