<?php

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\ServerResponse;

class ResetPasswordResponse extends ServerResponse
{
    public $view = 'auth.passwords.reset';
}
