<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\StoreDepartmentRequest;

class CreateDepartmentManager
{
    use AsAction;

    public function handle(StoreDepartmentRequest $request): Department
    {
        $department = CreateDepartment::run($request->getDepartmentData());

        UploadDepartmentHeaderImage::run($department, $request->image_path);

        return $department->refresh();
    }
}
