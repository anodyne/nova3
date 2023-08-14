<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class DuplicateDepartment
{
    use AsAction;

    public function handle(Department $original, DepartmentData $data): Department
    {
        $department = $original->replicate();
        $department->forceFill($data->all());
        $department->save();

        $original->positions->each(
            fn (Position $position) => $department->positions()->create($position->toArray())
        );

        return $department->refresh();
    }
}
