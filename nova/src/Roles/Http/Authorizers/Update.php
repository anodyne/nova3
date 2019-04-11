<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Update extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('role.update') && ! $this->route('role')->locked;
    }
}
