<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class LoginResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'auth.login'
        ];
    }
}
