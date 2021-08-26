<?php

declare(strict_types=1);

namespace Nova\Users\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllUsersResponse extends Responsable
{
    public $view = 'users.index';
}
