<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Http\Request;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class UpdateDepartmentManager
{
    protected $updateDepartment;

    protected $uploadHeaderImage;

    public function __construct(
        UpdateDepartment $updateDepartment,
        UploadDepartmentHeaderImage $uploadHeaderImage
    ) {
        $this->updateDepartment = $updateDepartment;
        $this->uploadHeaderImage = $uploadHeaderImage;
    }

    public function execute(Department $department, Request $request): Department
    {
        $department = $this->updateDepartment->execute(
            $department,
            DepartmentData::fromRequest($request)
        );

        $this->uploadHeaderImage->execute($department, $request->image_path);

        return $department->refresh();
    }
}
