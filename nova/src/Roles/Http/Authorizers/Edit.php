<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Edit extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('role.update') && ! $this->route('role')->locked;
    }
}
