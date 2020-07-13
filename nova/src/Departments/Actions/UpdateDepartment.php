<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;
use Nova\Departments\DataTransferObjects\DepartmentData;

class UpdateDepartment
{
    public function execute(Department $department, DepartmentData $data): Department
    {
        return tap($department)->update($data->toArray())->refresh();
    }
}
