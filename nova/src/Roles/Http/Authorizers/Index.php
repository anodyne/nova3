<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Index extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('role.create')
            || $this->user()->can('role.delete')
            || $this->user()->can('role.update');
    }
}
