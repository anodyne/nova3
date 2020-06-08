<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Roles\Actions\UpdateRoleManager;
use Nova\Roles\Http\Requests\UpdateRoleRequest;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Http\Responses\UpdateRoleResponse;

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

        return back()->withToast("{$role->display_name} was updated");
    }
}
