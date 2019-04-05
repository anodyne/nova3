<?php

namespace Nova\Authorization\Http\Authorizers;

use Silber\Bouncer\Database\Role;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Destroy extends BaseAuthorizer
{
    public function authorize()
    {
        $role = Role::find($this->route('role'))->first();

        return $role && $this->user()->can('delete', $role);
    }
}
