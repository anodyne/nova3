<?php

namespace Nova\Auth\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class EmailVerificationResponse extends ServerResponse
{
    public $view = 'auth.verify';
}
