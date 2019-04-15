<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\User;
use Nova\Users\Jobs;
use Nova\Users\Events;
use Nova\Roles\Models\Role;
use Nova\Users\Http\Requests;
use Nova\Users\Http\Responses;
use Nova\Users\Http\Resources;
use Nova\Users\Http\Authorizers;
use Nova\Foundation\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(Authorizers\Index $gate)
    {
        $users = User::get();

        return app(Responses\Index::class)
            ->withUsers(new Resources\UserCollection($users))
            ->withPendingUsers($users->pending());
    }

    public function create(Authorizers\Create $gate)
    {
        return app(Responses\Create::class)
            ->withRoles(Role::orderBy('title')->get());
    }

    public function store(Authorizers\Store $gate, Requests\Store $request)
    {
        $user = dispatch_now(new Jobs\Create($request->validated()));

        event(new Events\Created($user));

        return $user->fresh();
    }

    public function edit(Authorizers\Edit $gate, User $user)
    {
        return app(Responses\Edit::class)
            ->withUser(new Resources\UserResource($user));
    }

    public function update(Authorizers\Update $gate, Requests\Update $request, User $user)
    {
        $user = dispatch_now(new Jobs\Update($user, $request->validated()));

        event(new Events\Updated($user->fresh()));

        return $user->fresh();
    }

    public function destroy(Authorizers\Destroy $gate, User $user)
    {
        $user = dispatch_now(new Jobs\Delete($user));

        event(new Events\Deleted($user));

        return $user;
    }
}
