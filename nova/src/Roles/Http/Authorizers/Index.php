<?php

namespace Nova\Roles\Http\Authorizers;

use Silber\Bouncer\Database\Role;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Index extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('manage', Role::class);
    }

    public function userAbilities()
    {
        $role = new Role;

        return [
            'create' => $this->user()->can('create', Role::class),
            'update' => $this->user()->can('update', $role),
            'delete' => $this->user()->can('delete', $role),
        ];
    }
}
