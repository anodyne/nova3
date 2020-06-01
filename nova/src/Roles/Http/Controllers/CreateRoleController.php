<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Roles\Actions\CreateRoleManager;
use Nova\Roles\Http\Requests\CreateRoleRequest;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Http\Responses\CreateRoleResponse;

class CreateRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Role::class);

        return app(CreateRoleResponse::class);
    }

    public function store(CreateRoleRequest $request, CreateRoleManager $action)
    {
        $this->authorize('create', Role::class);

        $role = $action->execute($request);

        return redirect()
            ->route('roles.index')
            ->withToast("{$role->display_name} role was created.");
    }
}
