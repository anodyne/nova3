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

            activity()
                ->performedOn($department)
                ->event('uploaded')
                ->log('uploaded');
        }

        return $department->refresh();
    }
}
