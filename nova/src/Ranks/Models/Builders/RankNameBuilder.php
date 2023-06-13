<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Ranks\Enums\RankNameStatus;

class RankNameBuilder extends Builder
{
    public function searchFor($value): self
    {
        return $this->where('name', 'like', "%{$value}%");
    }

    public function active()
    {
        return $this->where('status', RankNameStatus::active);
    }
}
