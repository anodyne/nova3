<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;

class DuplicateDepartmentPositions
{
    public function execute(Department $department, Department $original): void
    {
        $original->positions->each(function ($position) use ($department) {
            $department->positions()->create($position->toArray());
        });
    }
}
