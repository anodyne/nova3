<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Store extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('role.create');
    }
}
