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
        if (is_null($imagePath)) {
            $department->clearMediaCollection('header');

            activity()
                ->performedOn($department)
                ->event('removed header image')
                ->log('removed header image');
        } else {
            $department->addMedia($imagePath)->toMediaCollection('header');

            activity()
                ->performedOn($department)
                ->event('uploaded header image')
                ->log('uploaded header image');
        }

        return $department->refresh();
    }
}
