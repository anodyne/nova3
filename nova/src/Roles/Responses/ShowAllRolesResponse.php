<?php

declare(strict_types=1);

namespace Nova\Roles\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllRolesResponse extends Responsable
{
    public $view = 'roles.index';
}
