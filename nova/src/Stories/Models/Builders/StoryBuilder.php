<?php

namespace Nova\Stories\Models\Builders;

use Kalnoy\Nestedset\QueryBuilder;
use Nova\Foundation\Filters\Filterable;

class StoryBuilder extends QueryBuilder
{
    use Filterable;
}
