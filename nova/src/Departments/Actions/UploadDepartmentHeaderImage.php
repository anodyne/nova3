<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;

class UploadDepartmentHeaderImage
{
    use AsAction;

    public function handle(Department $department, $imagePath): Department
    {
        if ($imagePath !== null) {
            $department->addMedia($imagePath)->toMediaCollection('header');
        }

        return $department->refresh();
    }
}
