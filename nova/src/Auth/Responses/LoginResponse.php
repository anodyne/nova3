<?php

declare(strict_types=1);

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\Responsable;

class LoginResponse extends Responsable
{
    public $view = 'auth.login';
}
