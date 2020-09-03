<?php

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\Responsable;

class EmailVerificationResponse extends Responsable
{
    public $view = 'auth.verify';
}
