<?php

namespace Nova\Roles\Http\Authorizors;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Index extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('role.create')
            || $this->user()->can('role.delete')
            || $this->user()->can('role.update');
    }
}
