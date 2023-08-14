<?php

declare(strict_types=1);

namespace Nova\Departments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Department;

class DepartmentCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Department $department
    ) {
    }
}
