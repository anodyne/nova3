<?php

namespace Nova\Roles\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class UpdateRoleResponse extends ServerResponse
{
    public $view = 'roles.edit';
}
