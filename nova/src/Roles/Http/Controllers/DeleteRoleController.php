<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Roles\Actions\DeleteRole;
use Nova\Foundation\Http\Controllers\Controller;

class DeleteRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(DeleteRole $action, Role $role)
    {
        $this->authorize('delete', $role);

        $action->execute($role);

        return redirect()
            ->route('roles.index')
            ->withToast("{$role->display_name} was deleted", 'All users who had been assigned this role have been updated.');
    }
}
