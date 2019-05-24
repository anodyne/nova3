<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Roles\Models\Role;
use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Store extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->allows('create', Role::class);
    }
}
