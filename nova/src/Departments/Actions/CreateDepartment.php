<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Foundation\Actions\Action;

class CreateDepartment extends Action
{
    public function handle(DepartmentData $data): Department
    {
        return Department::create($data->toArray());
    }
}
