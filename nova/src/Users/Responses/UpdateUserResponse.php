<?php

declare(strict_types=1);

namespace Nova\Users\Responses;

use Nova\Foundation\Responses\Responsable;

class UpdateUserResponse extends Responsable
{
    public $view = 'users.edit';
}
