<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Actions\CreateRole;
use Nova\Roles\DataTransferObjects\RoleData;
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

        return CreateRoleResponse::send();
    }

    public function store(CreateRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $role = CreateRole::run(RoleData::fromRequest($request));

        return redirect()
            ->route('roles.edit', $role)
            ->withToast("{$role->display_name} role was created");
    }
}
