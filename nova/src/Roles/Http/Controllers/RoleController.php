<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Roles\Http\Requests;
use Nova\Roles\Http\Responses;
use Nova\Roles\Models\Ability;
use Nova\Roles\Actions\CreateRole;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Actions\UpdateRole;
use Nova\Roles\Http\Resources\RoleResource;
use Nova\Roles\DataTransferObjects\RoleData;
use Nova\Roles\Http\Resources\RoleCollection;
use Nova\Foundation\Http\Controllers\Controller;

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
        return app(Responses\Index::class)->with([
            'roles' => new RoleCollection(Role::orderBy('title')->get()),
        ]);
    }

    public function create()
    {
        return app(Responses\Create::class)->with([
            'abilities' => Ability::orderBy('title')->get(),
        ]);
    }

    public function store(Requests\Store $request, CreateRole $action)
    {
        return $action->execute(RoleData::fromRequest($request));
    }

    public function edit(Role $role)
    {
        return app(Responses\Edit::class)->with([
            'role' => new RoleResource($role),
            'abilities' => Ability::orderBy('title')->get(),
        ]);
    }

    public function update(Requests\Update $request, UpdateRole $action, Role $role)
    {
        return $action->execute($role, RoleData::fromRequest($request));
    }

    public function destroy(Role $role, DeleteRole $action)
    {
        return $action->execute($role);
    }
}
