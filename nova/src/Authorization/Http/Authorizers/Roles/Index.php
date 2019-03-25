<?php

namespace Nova\Authorization\Http\Authorizers\Roles;

use Silber\Bouncer\Database\Role;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Index extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('manage', Role::class);
    }
}
