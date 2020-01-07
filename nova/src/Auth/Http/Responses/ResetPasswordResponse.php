<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ResetPasswordResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'auth.passwords.reset',
        ];
    }
}
