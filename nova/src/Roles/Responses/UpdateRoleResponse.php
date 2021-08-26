<?php

declare(strict_types=1);

namespace Nova\Roles\Responses;

use Nova\Foundation\Responses\Responsable;

class UpdateRoleResponse extends Responsable
{
    public $view = 'roles.edit';
}
