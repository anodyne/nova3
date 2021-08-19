<?php

namespace Nova\Departments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Department;

class DepartmentDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $department;

    public $original;

    public function __construct(Department $department, Department $original)
    {
        $this->department = $department;
        $this->original = $original;
    }
}
