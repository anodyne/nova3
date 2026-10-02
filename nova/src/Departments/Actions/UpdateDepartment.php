<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Foundation\Actions\Action;

class UpdateDepartment extends Action
{
    public function handle(Department $department, DepartmentData $data): Department
    {
        return tap($department)
            ->update($data->toArray())
            ->refresh();
    }
}
