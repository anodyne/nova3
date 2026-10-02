<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;
use Nova\Departments\Requests\StoreDepartmentRequest;
use Nova\Foundation\Actions\Action;
use Nova\Media\Actions\UploadImage;

class CreateDepartmentManager extends Action
{
    public function handle(StoreDepartmentRequest $request): Department
    {
        $department = CreateDepartment::run($request->getDepartmentData());

        UploadImage::run(
            model: $department,
            collection: 'header',
            action: $request->getImageAction(),
            tempPath: $request->getImageTempPath()
        );

        return $department->refresh();
    }
}
