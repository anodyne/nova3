<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Ranks\Enums\RankNameStatus;

class RankNameBuilder extends Builder
{
    public function active()
    {
        return $this->where('status', RankNameStatus::active);
    }

    public function inactive()
    {
        return $this->where('status', RankNameStatus::inactive);
    }

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
