<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Models\Department;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;

class PositionBuilder extends Builder
{
    use QueriesStatus;

    public function available(): self
    {
        return $this->where('available', '>', 0);
    }

    public function department($id): self
    {
        return $this->where('department_id', $id);
    }

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%")
            ->orWhereRelation('department', Department::column('name'), 'like', "%{$search}%");
    }
}
