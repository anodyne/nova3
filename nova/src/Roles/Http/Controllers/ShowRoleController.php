<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Roles\Http\Responses\ShowRoleResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Http\Responses\ShowAllRolesResponse;

class ShowRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::withCount('users')
            ->with(['users' => function ($query) {
                $query->limit(4);
            }])
            ->orderBy('display_name')
            ->filter($request->only('search'))
            ->paginate();

        return app(ShowAllRolesResponse::class)->with([
            'filters' => $request->all('search'),
            'roles' => $roles,
        ]);
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);

        return app(ShowRoleResponse::class)->with([
            'role' => $role->load('permissions', 'users'),
        ]);
    }
}
