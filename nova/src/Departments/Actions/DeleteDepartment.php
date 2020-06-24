<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Department;

class DeleteDepartment
{
    public function execute(Department $department): Department
    {
        return tap($department)->delete();
    }
}
