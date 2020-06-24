<?php

namespace Nova\Departments\Events;

use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Department;
use Illuminate\Foundation\Events\Dispatchable;

class DepartmentDeleted
{
    use Dispatchable;
    use SerializesModels;

    public $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }
}
