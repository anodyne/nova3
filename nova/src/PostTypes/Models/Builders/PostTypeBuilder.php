<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;

class PostTypeBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($search): Builder
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
