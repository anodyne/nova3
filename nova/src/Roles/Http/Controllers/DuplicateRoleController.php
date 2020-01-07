<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Http\Requests\Duplicate;
use Nova\Foundation\Http\Controllers\Controller;

class DuplicateRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Duplicate $request, DuplicateRole $action, Role $originalRole)
    {
        $this->authorize('create', Role::class);

        $role = $action->execute($originalRole);

        event(new RoleDuplicated($role, $originalRole));

        return $role->refresh();
    }
}
