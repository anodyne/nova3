<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Actions\CreateRoleManager;
use Nova\Roles\Actions\UpdateRoleManager;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\StoreRoleRequest;
use Nova\Roles\Requests\UpdateRoleRequest;
use Nova\Roles\Responses\CreateRoleResponse;
use Nova\Roles\Responses\EditRoleResponse;
use Nova\Roles\Responses\ListRolesResponse;
use Nova\Roles\Responses\ShowRoleResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Role::class);
    }

    public function index()
    {
        return ListRolesResponse::send();
    }

    public function show(Role $role)
    {
        return ShowRoleResponse::sendWith([
            'role' => $role->load('permissions', 'user'),
        ]);
    }

    public function create()
    {
        return CreateRoleResponse::send();
    }

    public function store(StoreRoleRequest $request)
    {
        $role = CreateRoleManager::run($request);

        return redirect()
            ->route('roles.index')
            ->notify("{$role->display_name} role was created");
    }

    public function edit(Role $role)
    {
        return EditRoleResponse::sendWith([
            'permissions' => Permission::get(),
            'role' => $role->load('user.media', 'permissions')->loadCount(['user', 'permissions']),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = UpdateRoleManager::run($role, $request);

        return redirect()
            // ->route('roles.edit', $role)
            ->route('roles.index')
            ->notify($role->display_name.' role was updated');
    }
}
