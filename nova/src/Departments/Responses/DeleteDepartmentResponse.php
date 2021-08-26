<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class DeleteDepartmentResponse extends Responsable
{
    public $view = 'departments.delete';
}
