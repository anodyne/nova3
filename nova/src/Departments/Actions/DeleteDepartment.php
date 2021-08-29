<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;

class DeleteDepartment
{
    use AsAction;

    public function execute(Department $department): Department
    {
        $department->positions->each(function ($position) {
            DeletePosition::run($position);
        });

        return tap($department)->delete();
    }
}
