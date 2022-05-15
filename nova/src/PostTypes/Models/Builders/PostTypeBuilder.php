<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;
use Nova\PostTypes\Models\States\Active;

class PostTypeBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($search): Builder
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function whereActive()
    {
        return $this->whereState('status', Active::class);
    }
}
