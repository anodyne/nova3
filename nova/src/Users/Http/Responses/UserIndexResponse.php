<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class UserIndexResponse extends ServerResponse
{
    public $view = 'users.index';
}
