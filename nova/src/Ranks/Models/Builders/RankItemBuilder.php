<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

/**
 * @extends Builder<RankItem>
 */
class RankItemBuilder extends Builder
{
    use QueriesStatus;

    public function group(int $group): self
    {
        return $this->where('group_id', $group);
    }

    public function name(int $name): self
    {
        return $this->where('name_id', $name);
    }

    public function searchFor(string $search): self
    {
        return $this->whereRelation('name', RankName::column('name'), 'like', "%{$search}%");
    }

    public function withRankName(): self
    {
        return $this->addSelect(['rank_name' => RankName::select('name')
            ->whereColumn('id', RankItem::column('name_id'))
            ->take(1),
        ]);
    }
}
