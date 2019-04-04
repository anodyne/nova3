<?php

namespace Nova\Authorization\Http\Authorizers;

use Silber\Bouncer\Database\Role;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Create extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('create', Role::class);
    }
}
