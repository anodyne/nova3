<?php

declare(strict_types=1);

namespace Nova\Departments\Models\States;

class Active extends DepartmentStatus
{
    public static $name = 'active';

    public function color(): string
    {
        return 'green';
    }

    public function name(): string
    {
        return 'active';
    }
}
