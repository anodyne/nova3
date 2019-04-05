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

    public function index(Authorizers\Index $auth)
    {
        return app(Responses\Index::class)
            ->withRoles(Role::orderBy('title')->get());
    }

    public function create(Authorizers\Create $auth)
    {
        return app(Responses\Create::class);
    }

    public function store(Authorizers\Store $auth, Requests\Store $request)
    {
        $role = dispatch_now(new Jobs\CreateRoleJob($request->validated()));

        event(new Events\RoleCreated($role));

        return $role->fresh();
    }

    public function edit(Authorizers\Edit $auth, Role $role)
    {
        return app(Responses\Edit::class)
            ->withRole($role);
    }

    public function update(Authorizers\Update $auth, Requests\Update $request, Role $role)
    {
        $role = dispatch_now(new Jobs\UpdateRoleJob($role, $request->validated()));

        event(new Events\RoleUpdated($role));

        return $role->fresh();
    }

    public function destroy(Authorizers\Destroy $auth, Role $role)
    {
        $role = dispatch_now(new Jobs\DeleteRoleJob($role));

        event(new Events\RoleDeleted($role));

        return $role;
    }
}
