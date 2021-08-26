<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class CreateDepartment
{
    public function execute(DepartmentData $data): Department
    {
        return Department::create(
            array_merge($data->toArray(), [
                'sort' => Department::count(),
            ])
        );
    }
}
