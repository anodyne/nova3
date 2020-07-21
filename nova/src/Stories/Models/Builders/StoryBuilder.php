<?php

namespace Nova\Stories\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Concerns\Sortable;

class StoryBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function whereIsParentStory(): Builder
    {
        return $this->where('story_id', null);
    }
}
