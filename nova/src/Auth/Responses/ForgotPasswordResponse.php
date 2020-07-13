<?php

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\ServerResponse;

class ForgotPasswordResponse extends ServerResponse
{
    public $view = 'auth.passwords.email';
}
