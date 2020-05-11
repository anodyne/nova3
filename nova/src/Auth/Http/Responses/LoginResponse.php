<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class LoginResponse extends ServerResponse
{
    public $view = 'auth.login';

    public function views(): array
    {
        return [
            'page' => 'auth.login',
        ];
    }
}
