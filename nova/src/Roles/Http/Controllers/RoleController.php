<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Jobs;
use Nova\Roles\Models\Role;
use Nova\Roles\Http\Requests;
use Nova\Roles\Http\Responses;
use Nova\Roles\Models\Ability;
use Nova\Roles\Http\Resources\RoleResource;
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
        return app(Responses\Index::class)
            ->withRoles(new RoleCollection(Role::orderBy('title')->get()));
    }

    public function create()
    {
        return app(Responses\Create::class)
            ->withAbilities(Ability::orderBy('title')->get());
    }

    public function store(Requests\Store $request)
    {
        return Jobs\CreateRole::dispatchNow($request->validated());
    }

    public function edit(Role $role)
    {
        return app(Responses\Edit::class)
            ->withRole(new RoleResource($role))
            ->withAbilities(Ability::orderBy('title')->get());
    }

    public function update(Requests\Update $request, Role $role)
    {
        return Jobs\UpdateRole::dispatchNow($role, $request->validated());
    }

    public function destroy(Role $role)
    {
        return Jobs\DeleteRole::dispatchNow($role);
    }
}
