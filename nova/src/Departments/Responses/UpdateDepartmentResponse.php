<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class UpdateDepartmentResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'departments.edit';
}
