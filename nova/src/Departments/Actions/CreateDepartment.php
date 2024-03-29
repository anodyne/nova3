<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;

class CreateDepartment
{
    use AsAction;

    public function handle(DepartmentData $data): Department
    {
        return Department::create($data->all());
    }
}
