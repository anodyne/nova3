<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Enums\PositionStatus;

class PositionBuilder extends Builder
{
    public function searchFor($value): self
    {
        return $this->where('name', 'like', "%{$value}%")
            ->orWhereHas('department', fn ($query) => $query->where('name', 'like', "%{$value}%"));
    }

    public function active()
    {
        return $this->where('status', PositionStatus::active);
    }

    public function available()
    {
        return $this->where('available', '>', 0);
    }

    public function department($id)
    {
        return $this->where('department_id', $id);
    }
}
