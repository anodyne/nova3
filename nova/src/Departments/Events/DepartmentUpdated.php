<?php

declare(strict_types=1);

namespace Nova\Departments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Department;

class DepartmentUpdated
{
    use Dispatchable;
    use SerializesModels;

    public $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }
}
