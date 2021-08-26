<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateDepartmentResponse extends Responsable
{
    public $view = 'departments.create';
}
