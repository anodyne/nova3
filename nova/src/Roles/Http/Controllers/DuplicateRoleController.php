<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Http\Requests\ValidateDuplicateRole;

class DuplicateRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(
        ValidateDuplicateRole $request,
        DuplicateRole $action,
        Role $originalRole
    ) {
        $this->authorize('duplicate', $originalRole);

        $role = $action->execute($originalRole);

        event(new RoleDuplicated($role, $originalRole));

        return redirect()
            ->route('roles.edit', $role)
            ->withToast("{$originalRole->display_name} has been duplicated.");
    }
}
