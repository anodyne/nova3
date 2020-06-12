<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class LoginResponse extends ServerResponse
{
    public $view = 'auth.login';
}
