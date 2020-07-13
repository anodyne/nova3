<?php

namespace Nova\Departments\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Concerns\Sortable;

class PositionBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function whereActive()
    {
        return $this->where('active', true);
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
