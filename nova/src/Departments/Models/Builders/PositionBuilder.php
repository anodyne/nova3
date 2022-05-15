<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Models\States\Positions\Active;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;

class PositionBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($value): self
    {
        return $this->where('name', 'like', "%{$value}%")
            ->orWhereHas('department', fn ($query) => $query->where('name', 'like', "%{$value}%"));
    }

    public function whereActive()
    {
        return $this->whereState('status', Active::class);
    }

    public function whereAvailable()
    {
        return $this->where('available', '>', 0);
    }

    public function whereDepartment($id)
    {
        return $this->where('department_id', $id);
    }
}
