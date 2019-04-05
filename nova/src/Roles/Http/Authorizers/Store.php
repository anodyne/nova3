<?php

namespace Nova\Roles\Http\Authorizers;

use Silber\Bouncer\Database\Role;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Store extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('create', Role::class);
    }
}
