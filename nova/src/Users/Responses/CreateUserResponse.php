<?php

declare(strict_types=1);

namespace Nova\Users\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateUserResponse extends Responsable
{
    public string $view = 'users.create';
}
