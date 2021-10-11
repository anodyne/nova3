<?php

declare(strict_types=1);

namespace Nova\Roles\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllRolesResponse extends Responsable
{
    public ?string $subnav = 'users';

    public string $view = 'roles.index';
}
