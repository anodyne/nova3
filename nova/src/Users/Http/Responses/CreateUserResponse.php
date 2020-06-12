<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class CreateUserResponse extends ServerResponse
{
    public $view = 'users.create';
}
