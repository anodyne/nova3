<?php

declare(strict_types=1);

namespace Nova\Departments\Models\States\Departments;

class Active extends DepartmentStatus
{
    public static $name = 'active';

    public function color(): string
    {
        return 'success';
    }

    public function bgColor(): string
    {
        return "bg-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'active';
    }
}
