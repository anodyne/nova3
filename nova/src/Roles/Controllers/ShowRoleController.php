<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
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

    public function all()
    {
        $this->authorize('viewAny', Role::class);

        return ShowAllRolesResponse::send();
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);

        return ShowRoleResponse::sendWith([
            'role' => $role->load('permissions', 'user'),
            'users' => $role->user()->active()->get(),
        ]);
    }
}
