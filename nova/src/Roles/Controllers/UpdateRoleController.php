<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Actions\UpdateRoleManager;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\UpdateRoleRequest;
use Nova\Roles\Responses\UpdateRoleResponse;

class UpdateRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        return app(UpdateRoleResponse::class)->with([
            'permissions' => Permission::get(),
            'role' => $role->load('users.media', 'permissions'),
        ]);
    }

    public function update(
        UpdateRoleRequest $request,
        UpdateRoleManager $action,
        Role $role
    ) {
        $this->authorize('update', $role);

        $role = $action->execute($role, $request);

        return back()->withToast("{$role->display_name} role was updated");
    }
}
