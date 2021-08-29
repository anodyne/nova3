<?php

declare(strict_types=1);

namespace Nova\Roles\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateRoleResponse extends Responsable
{
    public string $view = 'roles.create';
}
