<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Enums\PositionStatus;

class PositionBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('status', PositionStatus::active);
    }

    public function available(): self
    {
        return $this->where('available', '>', 0);
    }

    public function department($id): self
    {
        return $this->where('department_id', $id);
    }

    public function inactive(): self
    {
        return $this->where('status', PositionStatus::inactive);
    }

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%")
            ->orWhereRelation('department', 'departments.name', 'like', "%{$search}%");
    }
}
