<?php

namespace Nova\Departments\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class PositionBuilder extends Builder
{
    use Filterable;

    public function orderBySort()
    {
        return $this->orderBy('sort', 'asc');
    }

    public function whereDepartment($id)
    {
        return $this->where('department_id', $id);
    }
}
