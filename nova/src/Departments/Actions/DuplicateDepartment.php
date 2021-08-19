<?php

namespace Nova\Departments\Actions;

use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class DuplicateDepartment
{
    public function execute(Department $original, DepartmentData $data): Department
    {
        $department = $original->replicate()->fill($data->toArray());

        $department->save();

        return $department->fresh();
    }
}
