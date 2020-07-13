<?php

namespace Nova\Departments\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Concerns\Sortable;

class DepartmentBuilder extends Builder
{
    use Filterable;
    use Sortable;
}
