<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;

class UpdateDepartment
{
    use AsAction;

    public function handle(Department $department, DepartmentData $data): Department
    {
        return tap($department)
            ->update($data->all())
            ->refresh();
    }
}
