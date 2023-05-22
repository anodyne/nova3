<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Enums\DepartmentStatus;

class DepartmentBuilder extends Builder
{
    public function searchFor($value): self
    {
        return $this->where('name', 'like', "%{$value}%")
            ->orWhereHas('positions', fn ($query) => $query->where('name', 'like', "%{$value}%"));
    }

    public function active()
    {
        return $this->where('status', DepartmentStatus::active);
    }
}
