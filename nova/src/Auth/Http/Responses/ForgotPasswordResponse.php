<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class ForgotPasswordResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'auth.passwords.email'
        ];
    }
}
