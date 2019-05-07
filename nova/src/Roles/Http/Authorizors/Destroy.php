<?php

namespace Nova\Roles\Http\Authorizors;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Destroy extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('role.delete') && ! $this->route('role')->locked;
    }
}
