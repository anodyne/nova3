<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class RequestPasswordResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'auth.passwords.email',
        ];
    }
}
