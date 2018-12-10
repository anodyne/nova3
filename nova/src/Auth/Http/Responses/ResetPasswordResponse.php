<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class ResetPasswordResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'auth.passwords.reset',
        ];
    }
}
