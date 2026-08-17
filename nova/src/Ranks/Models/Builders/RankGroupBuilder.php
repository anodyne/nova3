<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Ranks\Models\RankGroup;

/**
 * @template TModel of RankGroup
 *
 * @extends Builder<TModel>
 */
class RankGroupBuilder extends Builder
{
    use QueriesStatus;

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
