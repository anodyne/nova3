<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowUserResponse extends ServerResponse
{
    public $view = 'users.show';
}
