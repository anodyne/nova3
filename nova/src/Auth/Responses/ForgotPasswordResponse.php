<?php

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\Responsable;

class ForgotPasswordResponse extends Responsable
{
    public $view = 'auth.passwords.email';
}
