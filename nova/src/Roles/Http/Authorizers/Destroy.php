<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Destroy extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('role.delete') && ! $this->route('role')->locked;
    }
}
