<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;

class DuplicateDepartmentManager
{
    use AsAction;

    public function handle(Department $original, array $data): Department
    {
        $department = DuplicateDepartment::run(
            $original,
            DepartmentData::from($data)
        );

        DuplicateDepartmentPositions::run($department, $original);

        return $department->refresh();
    }
}
