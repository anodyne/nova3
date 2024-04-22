<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Ranks\Enums\RankGroupStatus;

class RankGroupBuilder extends Builder
{
    public function active()
    {
        return $this->where('status', RankGroupStatus::active);
    }

    public function inactive()
    {
        return $this->where('status', RankGroupStatus::inactive);
    }

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
