<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class UpdateUserResponse extends ServerResponse
{
    public $view = 'users.edit';
}
