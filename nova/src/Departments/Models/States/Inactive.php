<?php

declare(strict_types=1);

namespace Nova\Departments\Models\States;

class Inactive extends DepartmentStatus
{
    public static $name = 'inactive';

    public function color(): string
    {
        return 'red';
    }

    public function name(): string
    {
        return 'inactive';
    }
}
