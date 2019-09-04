<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Jobs;
use Nova\Users\Events;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Users\Http\Resources;
use Nova\Users\Http\Responses;
use Nova\Users\Http\Validators;
use Nova\Foundation\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::get();

        return app(Responses\Index::class)
            ->withUsers(new Resources\UserCollection($users))
            ->withPendingUsers($users->pending());
    }

    public function create()
    {
        return app(Responses\Create::class)
            ->withRoles(Role::orderBy('title')->get());
    }

    public function store(Validators\Store $request)
    {
        $user = Jobs\Create::dispatchNow($request->validated());

        event(new Events\AdminCreated($user));

        return $user->refresh();
    }

    public function edit(User $user)
    {
        return app(Responses\Edit::class)
            ->withRoles(Role::orderBy('title')->get())
            ->withUser(new Resources\UserResource($user));
    }

    public function update(Validators\Update $request, User $user)
    {
        $user = Jobs\Update::dispatchNow($user, $request->validated());

        event(new Events\AdminUpdated($user->refresh()));

        return $user;
    }

    public function destroy(User $user)
    {
        $user = Jobs\Delete::dispatchNow($user);

        event(new Events\AdminDeleted($user));

        return $user;
    }
}
