<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Store extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('role.create');
    }
}
