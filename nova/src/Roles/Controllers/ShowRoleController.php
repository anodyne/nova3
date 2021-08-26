<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Filters\RoleFilters;
use Nova\Roles\Models\Role;
use Nova\Roles\Responses\ShowAllRolesResponse;
use Nova\Roles\Responses\ShowRoleResponse;

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
