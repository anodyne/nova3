<?php

namespace Nova\Auth\Responses;

use Nova\Foundation\Responses\ServerResponse;

class EmailVerificationResponse extends ServerResponse
{
    public $view = 'auth.verify';
}
