<?php

declare(strict_types=1);

namespace Nova\Departments\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Models\Concerns\QueriesUniqueTags;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;

/**
 * @template TModel of Department
 *
 * @extends Builder<TModel>
 */
class DepartmentBuilder extends Builder
{
    use QueriesStatus;
    use QueriesUniqueTags;

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%")
            ->orWhereRelation('positions', Position::column('name'), 'like', "%{$search}%");
    }
}
