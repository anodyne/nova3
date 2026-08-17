<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Models\Concerns\QueriesUniqueTags;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;

/**
 * @template TModel of Position
 *
 * @extends Builder<TModel>
 */
class PositionBuilder extends Builder
{
    use QueriesStatus;
    use QueriesUniqueTags;

    public function available(): self
    {
        return $this->where('available', '>', 0);
    }

    public function forDepartment($id): self
    {
        return $this->where('department_id', $id);
    }

    public function searchFor($search): self
    {
        return $this->where(Position::column('name'), 'like', "%{$search}%")
            ->orWhereRelation('department', Department::column('name'), 'like', "%{$search}%");
    }
}
