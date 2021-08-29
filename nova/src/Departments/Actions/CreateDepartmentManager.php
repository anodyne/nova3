<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class CreateDepartmentManager
{
    use AsAction;

    public function handle(Request $request): Department
    {
        $department = CreateDepartment::run(
            DepartmentData::fromRequest($request)
        );

        UploadDepartmentHeaderImage::run($department, $request->image_path);

        return $department->refresh();
    }
}
