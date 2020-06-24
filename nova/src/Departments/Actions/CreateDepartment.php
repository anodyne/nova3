<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;
use Nova\Departments\DataTransferObjects\DepartmentData;

class CreateDepartment
{
    public function execute(DepartmentData $data): Department
    {
        return Department::create($data->toArray());
    }
}
