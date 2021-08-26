<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;

class DeleteDepartment
{
    protected $deletePosition;

    public function __construct(DeletePosition $deletePosition)
    {
        $this->deletePosition = $deletePosition;
    }

    public function execute(Department $department): Department
    {
        $department->positions->each(function ($position) {
            $this->deletePosition->execute($position);
        });

        return tap($department)->delete();
    }
}
