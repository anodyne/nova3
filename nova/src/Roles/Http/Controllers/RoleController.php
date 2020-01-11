<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Http\Requests;
use Nova\Roles\Http\Responses;
use Nova\Roles\Models\Ability;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Actions\CreateRoleManager;
use Nova\Roles\Actions\UpdateRoleManager;
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
        return app(Responses\Index::class)->with([
            'roles' => new RoleCollection(Role::orderBy('title')->get()),
        ]);
    }

    public function create()
    {
        return app(Responses\Create::class)->with([
            'abilities' => Ability::orderBy('title')->get(),
            'users' => User::get(),
        ]);
    }

    public function store(Requests\Store $request, CreateRoleManager $action)
    {
        return $action->execute($request);
    }

    public function edit(Role $role)
    {
        return app(Responses\Edit::class)->with([
            'role' => new RoleResource($role),
            'abilities' => Ability::orderBy('title')->get(),
            'users' => User::get(),
        ]);
    }

    public function update(Requests\Update $request, UpdateRoleManager $action, Role $role)
    {
        return $action->execute($role, $request);
    }

    public function destroy(Role $role, DeleteRole $action)
    {
        return $action->execute($role);
    }
}
