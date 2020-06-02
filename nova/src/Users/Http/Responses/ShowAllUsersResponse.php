<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllUsersResponse extends ServerResponse
{
    public $view = 'users.index';
}
