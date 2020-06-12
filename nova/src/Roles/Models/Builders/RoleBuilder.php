<?php

namespace Nova\Roles\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class RoleBuilder extends Builder
{
    use Filterable;

    public function whereDefault(): Builder
    {
        return $this->where('default', true);
    }
}
