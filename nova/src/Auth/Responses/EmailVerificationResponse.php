<?php

declare(strict_types=1);

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\Responsable;

class EmailVerificationResponse extends Responsable
{
    public $view = 'auth.verify';
}
