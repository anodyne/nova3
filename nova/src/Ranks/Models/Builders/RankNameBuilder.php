<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Ranks\Models\States\Names\Active;

class RankNameBuilder extends Builder
{
    public function searchFor($value): self
    {
        return $this->where('name', 'like', "%{$value}%");
    }

    public function whereActive()
    {
        return $this->whereState('status', Active::class);
    }
}
