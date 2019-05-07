<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Jobs;
use Nova\Roles\Events;
use Nova\Roles\Models\Role;
use Nova\Roles\Http\Responses;
use Nova\Roles\Models\Ability;
use Nova\Roles\Http\Validators;
use Nova\Roles\Http\Authorizors;
use Nova\Roles\Http\Resources\RoleResource;
use Nova\Roles\Http\Resources\RoleCollection;
use Nova\Foundation\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(Authorizors\Index $gate)
    {
        return app(Responses\Index::class)
            ->withRoles(new RoleCollection(Role::orderBy('title')->get()));
    }

    public function create(Authorizors\Create $gate)
    {
        return app(Responses\Create::class)
            ->withAbilities(Ability::orderBy('title')->get());
    }

    public function store(Authorizors\Store $gate, Validators\Store $request)
    {
        $role = dispatch_now(new Jobs\Create($request->validated()));

        return $role->fresh();
    }

    public function edit(Authorizors\Edit $gate, Role $role)
    {
        return app(Responses\Edit::class)
            ->withRole(new RoleResource($role))
            ->withAbilities(Ability::orderBy('title')->get());
    }

    public function update(Authorizors\Update $gate, Validators\Update $request, Role $role)
    {
        $role = dispatch_now(new Jobs\Update($role, $request->validated()));

        return $role->fresh();
    }

    public function destroy(Authorizors\Destroy $gate, Role $role)
    {
        $role = dispatch_now(new Jobs\Delete($role));

        return $role;
    }
}
