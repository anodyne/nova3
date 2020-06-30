<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Roles\Filters\RoleFilters;
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

    public function all(Request $request, RoleFilters $filters)
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::withCount('users')
            ->with(['users' => function ($query) {
                $query->limit(4);
            }])
            ->orderBySort()
            ->filter($filters);

        $roles = ($isReordering = $request->has('reorder'))
            ? $roles->get()
            : $roles->paginate();

        return app(ShowAllRolesResponse::class)->with([
            'isReordering' => $isReordering,
            'roles' => $roles,
            'search' => $request->search,
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
