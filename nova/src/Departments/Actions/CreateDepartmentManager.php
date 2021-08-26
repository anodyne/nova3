<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Http\Request;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class CreateDepartmentManager
{
    protected $createDepartment;

    protected $uploadHeaderImage;

    public function __construct(
        CreateDepartment $createDepartment,
        UploadDepartmentHeaderImage $uploadHeaderImage
    ) {
        $this->createDepartment = $createDepartment;
        $this->uploadHeaderImage = $uploadHeaderImage;
    }

    public function execute(Request $request): Department
    {
        $department = $this->createDepartment->execute(
            DepartmentData::fromRequest($request)
        );

        $this->uploadHeaderImage->execute($department, $request->image_path);

        return $department->refresh();
    }
}
