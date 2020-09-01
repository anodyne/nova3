<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;

class UploadDepartmentHeaderImage
{
    public function execute(Department $department, $imagePath): Department
    {
        if ($imagePath !== null) {
            $department->addMedia($imagePath)->toMediaCollection('header');
        }

        return $department->refresh();
    }
}
