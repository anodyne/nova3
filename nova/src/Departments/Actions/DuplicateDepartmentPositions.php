<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;

class DuplicateDepartmentPositions
{
    use AsAction;

    public function handle(Department $department, Department $original): void
    {
        $original->positions->each(function ($position) use ($department) {
            $department->positions()->create($position->toArray());
        });
    }
}
