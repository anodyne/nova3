<?php

declare(strict_types=1);

namespace Nova\Roles\Responses;

use Nova\Foundation\Responses\Responsable;

class DeleteRoleResponse extends Responsable
{
    public $view = 'roles.delete';
}
