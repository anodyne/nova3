<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Jobs;
use Nova\Users\Events;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Users\Http\Requests;
use Nova\Users\Http\Responses;
use Nova\Users\Http\Resources\UserResource;
use Nova\Users\Http\Resources\UserCollection;
use Nova\Foundation\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(User::class);
    }

    public function index()
    {
        $users = User::get();

        return app(Responses\Index::class)
            ->withUsers(new UserCollection($users))
            ->withPendingUsers($users->pending());
    }

    public function create()
    {
        return app(Responses\Create::class)
            ->withRoles(Role::orderBy('title')->get());
    }

    public function store(Requests\Store $request)
    {
        $user = Jobs\CreateUser::dispatchNow($request->validated());

        event(new Events\UserCreatedByAdmin($user));

        return $user->refresh();
    }

    public function edit(User $user)
    {
        return app(Responses\Edit::class)
            ->withRoles(Role::orderBy('title')->get())
            ->withUser(new UserResource($user));
    }

    public function update(Requests\Update $request, User $user)
    {
        $user = Jobs\UpdateUser::dispatchNow($user, $request->validated());

        event(new Events\UserUpdatedByAdmin($user->refresh()));

        return $user->refresh();
    }

    public function destroy(User $user)
    {
        $user = Jobs\DeleteUser::dispatchNow($user);

        event(new Events\UserDeletedByAdmin($user));

        return $user;
    }
}
