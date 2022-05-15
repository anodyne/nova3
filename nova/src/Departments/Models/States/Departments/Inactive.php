<?php

declare(strict_types=1);

namespace Nova\Departments\Models\States\Departments;

class Inactive extends DepartmentStatus
{
    public static $name = 'inactive';

    public function color(): string
    {
        return 'red';
    }

    public function bgColor(): string
    {
        return "bg-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'inactive';
    }
}
