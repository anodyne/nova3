<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;

class DeleteDepartment
{
    use AsAction;

    public function handle(Department $department): Department
    {
        $department->positions->each(
            fn ($position) => DeletePosition::run($position)
        );

        return tap($department)->delete();
    }
}
