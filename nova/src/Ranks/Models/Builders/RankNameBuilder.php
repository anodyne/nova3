<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Ranks\Models\RankName;

/**
 * @extends Builder<RankName>
 */
class RankNameBuilder extends Builder
{
    use QueriesStatus;

    public function searchFor(string $search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
