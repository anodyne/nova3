<?php

namespace Nova\Users\Responses;

use Nova\Foundation\Responses\ServerResponse;

class DeactivateUserResponse extends ServerResponse
{
    public $view = 'users.deactivate';
}
