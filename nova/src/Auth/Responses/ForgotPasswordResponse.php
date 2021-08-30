<?php

declare(strict_types=1);

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\Responsable;

class ForgotPasswordResponse extends Responsable
{
    public string $view = 'auth.passwords.email';
}
