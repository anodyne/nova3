<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class UpdateDepartmentManager
{
    use AsAction;

    public function handle(Department $department, Request $request): Department
    {
        $department = UpdateDepartment::run(
            $department,
            DepartmentData::fromRequest($request)
        );

        UploadDepartmentHeaderImage::run($department, $request->image_path);

        return $department->refresh();
    }
}
