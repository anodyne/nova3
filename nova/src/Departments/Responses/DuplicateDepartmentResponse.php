<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class DuplicateDepartmentResponse extends Responsable
{
    public string $view = 'departments.duplicate';
}
