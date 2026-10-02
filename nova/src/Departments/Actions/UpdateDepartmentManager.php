<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;
use Nova\Departments\Requests\UpdateDepartmentRequest;
use Nova\Foundation\Actions\Action;
use Nova\Media\Actions\UploadImage;

class UpdateDepartmentManager extends Action
{
    public function handle(Department $department, UpdateDepartmentRequest $request): Department
    {
        $department = UpdateDepartment::run(
            $department,
            $request->getDepartmentData()
        );

        UploadImage::run(
            model: $department,
            collection: 'header',
            action: $request->getImageAction(),
            tempPath: $request->getImageTempPath()
        );

        return $department->refresh();
    }
}
