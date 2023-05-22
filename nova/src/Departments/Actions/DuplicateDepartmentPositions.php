<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class DuplicateDepartmentPositions
{
    use AsAction;

    public function handle(Department $department, Department $original): void
    {
        $original->positions->each(
            fn (Position $position) => $department->positions()->create($position->toArray())
        );
    }
}
