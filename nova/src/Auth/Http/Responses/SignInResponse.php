<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class SignInResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'auth.sign-in',
        ];
    }
}
