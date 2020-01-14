<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Events;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Users\Http\Requests;
use Nova\Users\Http\Responses;
use Nova\Users\Actions\CreateUser;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Actions\UpdateUser;
use Nova\Users\Http\Resources\UserResource;
use Nova\Users\DataTransferObjects\UserData;
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

        return app(Responses\Index::class)->with([
            'users' => new UserCollection($users),
            'pendingUsers' => $users->pending(),
        ]);
    }

    public function create()
    {
        return app(Responses\Create::class)->with([
            'roles' => Role::orderBy('title')->get(),
        ]);
    }

    public function store(Requests\Store $request, CreateUser $action)
    {
        $user = $action->execute(UserData::fromRequest($request));

        event(new Events\UserCreatedByAdmin($user));

        return $user->refresh();
    }

    public function edit(User $user)
    {
        return app(Responses\Edit::class)->with([
            'roles' => Role::orderBy('title')->get(),
            'user' => new UserResource($user),
        ]);
    }

    public function update(Requests\Update $request, UpdateUser $action, User $user)
    {
        $user = $action->execute($user, UserData::fromRequest($request));

        event(new Events\UserUpdatedByAdmin($user->refresh()));

        return $user;
    }

    public function destroy(DeleteUser $action, User $user)
    {
        $user = $action->execute($user);

        event(new Events\UserDeletedByAdmin($user));

        return $user;
    }
}
