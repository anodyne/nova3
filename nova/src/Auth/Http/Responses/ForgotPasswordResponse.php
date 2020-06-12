<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ForgotPasswordResponse extends ServerResponse
{
    public $view = 'auth.passwords.email';
}
