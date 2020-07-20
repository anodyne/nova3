<?php

namespace Nova\Stories\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Concerns\Sortable;

class StoryBuilder extends Builder
{
    use Sortable;
}
