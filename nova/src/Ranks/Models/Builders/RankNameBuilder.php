<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;

class RankNameBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($value): self
    {
        return $this->where('name', 'like', "%{$value}%");
    }
}
