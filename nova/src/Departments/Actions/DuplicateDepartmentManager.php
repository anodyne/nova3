<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class DuplicateDepartmentManager
{
    use AsAction;

    public function handle(Department $original, Request $request): Department
    {
        $department = DuplicateDepartment::run(
            $original,
            DepartmentData::fromRequest($request)
        );

        DuplicateDepartmentPositions::run($department, $original);

        return $department->refresh();
    }
}
