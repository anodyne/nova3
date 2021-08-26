<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;

class ReorderDepartments
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($deptId, $index) {
            Department::where('id', $deptId)->update(['sort' => $index]);
        });
    }
}
