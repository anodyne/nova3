<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class EmailVerificationResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'auth.verify',
        ];
    }
}
