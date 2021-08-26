<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Actions\CreateRoleManager;
use Nova\Roles\Models\Role;
use Nova\Roles\Requests\CreateRoleRequest;
use Nova\Roles\Responses\CreateRoleResponse;

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
            ->withToast("{$role->display_name} role was created");
    }
}
