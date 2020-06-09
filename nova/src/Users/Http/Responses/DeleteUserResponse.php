<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class DeleteUserResponse extends ServerResponse
{
    public $view = 'users.delete';
}
