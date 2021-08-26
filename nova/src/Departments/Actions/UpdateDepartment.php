<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class UpdateDepartment
{
    public function execute(Department $department, DepartmentData $data): Department
    {
        return tap($department)->update($data->toArray())->refresh();
    }
}
