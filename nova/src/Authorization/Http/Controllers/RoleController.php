<?php

namespace Nova\Authorization\Http\Controllers;

use Nova\Authorization\Jobs;
use Nova\Authorization\Events;
use Silber\Bouncer\Database\Role;
use Nova\Authorization\Http\Requests;
use Nova\Authorization\Http\Responses;
use Nova\Authorization\Http\Authorizers;
use Nova\Foundation\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(Authorizers\Roles\Index $auth)
    {
        return app(Responses\Roles\Index::class)
            ->withRoles(Role::orderBy('title')->get());
    }

    public function create(Authorizers\Roles\Create $auth)
    {
        return app(Responses\Roles\Create::class);
    }

    public function store(Authorizers\Roles\Store $auth, Requests\Roles\Store $request)
    {
        $role = dispatch_now(new Jobs\CreateRoleJob($request->validated()));

        event(new Events\RoleCreated($role));

        return $role->fresh();
    }

    public function edit(Authorizers\Roles\Edit $auth, Role $role)
    {
        return app(Responses\Roles\Edit::class)
            ->withRole($role);
    }

    public function update(Authorizers\Roles\Update $auth, Requests\Roles\Update $request, Role $role)
    {
        $role = dispatch_now(new Jobs\UpdateRoleJob($role, $request->validated()));

        event(new Events\RoleUpdated($role));

        return $role->fresh();
    }

    public function destroy(Authorizers\Roles\Destroy $auth, Role $role)
    {
        $role = dispatch_now(new Jobs\DeleteRoleJob($role));

        event(new Events\RoleDeleted($role));

        return $role;
    }
}
