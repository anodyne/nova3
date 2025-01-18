<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\UpdateDepartmentRequest;
use Spatie\Activitylog\Facades\LogBatch;

class UpdateDepartmentManager
{
    use AsAction;

    public function handle(Department $department, UpdateDepartmentRequest $request): Department
    {
        LogBatch::startBatch();

        $department = UpdateDepartment::run(
            $department,
            $request->getDepartmentData()
        );

        UploadDepartmentHeaderImage::run($department, $request->image_path);

        LogBatch::endBatch();

        return $department->refresh();
    }
}
