<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Roles\Models\Role;
use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Index extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->any(['create', 'update', 'delete'], new Role);
    }
}
