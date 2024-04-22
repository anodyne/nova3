<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Enums\DepartmentStatus;

class DepartmentBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('status', DepartmentStatus::active);
    }

    public function inactive(): self
    {
        return $this->where('status', DepartmentStatus::inactive);
    }

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%")
            ->orWhereRelation('positions', 'positions.name', 'like', "%{$search}%");
    }
}
