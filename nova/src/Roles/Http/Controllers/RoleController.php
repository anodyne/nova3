<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Actions\CreateRoleManager;
use Nova\Roles\Actions\UpdateRoleManager;
use Nova\Roles\Http\Resources\RoleResource;
use Nova\Roles\Http\Resources\RoleCollection;
use Nova\Roles\Http\Requests\ValidateStoreRole;
use Nova\Roles\Http\Responses\EditRoleResponse;
use Nova\Roles\Http\Responses\ViewRoleResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Http\Requests\ValidateUpdateRole;
use Nova\Roles\Http\Responses\RoleIndexResponse;
use Nova\Roles\Http\Responses\CreateRoleResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Role::class);
    }

    public function index(Request $request)
    {
        $roles = Role::withCount('users')
            ->with(['users' => function ($query) {
                $query->limit(4);
            }])
            ->orderBy('display_name')
            ->filter($request->only('search'))
            ->paginate();

        return app(RoleIndexResponse::class)->with([
            'filters' => $request->all('search'),
            'roles' => new RoleCollection($roles),
        ]);
    }

    public function show(Role $role)
    {
        return app(ViewRoleResponse::class)->with([
            'role' => new RoleResource($role->load('permissions', 'users')),
        ]);
    }

    public function create()
    {
        return app(CreateRoleResponse::class);
    }

    public function store(ValidateStoreRole $request, CreateRoleManager $action)
    {
        $role = $action->execute($request);

        return redirect()
            ->route('roles.index')
            ->withToast("{$role->display_name} role was created.");
    }

    public function edit(Role $role)
    {
        return app(EditRoleResponse::class)->with([
            'role' => new RoleResource($role->load('users', 'permissions')),
        ]);
    }

    public function update(
        ValidateUpdateRole $request,
        UpdateRoleManager $action,
        Role $role
    ) {
        $role = $action->execute($role, $request);

        return back()->withToast("{$role->display_name} was updated.");
    }

    public function destroy(Role $role, DeleteRole $action)
    {
        $action->execute($role);

        return redirect()
            ->route('roles.index')
            ->withToast("{$role->display_name} was deleted.");
    }
}
