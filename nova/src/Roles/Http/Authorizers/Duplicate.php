<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Duplicate extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('role.create');
    }
}
