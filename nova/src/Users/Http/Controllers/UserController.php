<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\Actions\CreateUser;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Actions\UpdateUserManager;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Http\Resources\UserResource;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Http\Resources\UserCollection;
use Nova\Users\Http\Requests\ValidateStoreUser;
use Nova\Users\Http\Responses\EditUserResponse;
use Nova\Users\Http\Responses\ViewUserResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Users\Http\Requests\ValidateUpdateUser;
use Nova\Users\Http\Responses\UserIndexResponse;
use Nova\Users\Http\Responses\CreateUserResponse;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(User::class);
    }

    public function index(Request $request)
    {
        $users = User::orderBy('name')
            ->filter($request->only('search'))
            ->paginate(15);

        return app(UserIndexResponse::class)->with([
            'filters' => $request->all('search'),
            'users' => new UserCollection($users),
        ]);
    }

    public function show(User $user)
    {
        return app(ViewUserResponse::class)->with([
            'user' => new UserResource($user->load('roles')),
        ]);
    }

    public function create()
    {
        return app(CreateUserResponse::class)->with([
            'user' => new UserResource(auth()->user()),
        ]);
    }

    public function store(ValidateStoreUser $request, CreateUser $action)
    {
        $user = $action->execute(UserData::fromRequest($request));

        event(new UserCreatedByAdmin($user));

        return redirect()
            ->route('users.index')
            ->withToast("An account for {$user->name} was created.");
    }

    public function edit(User $user)
    {
        return app(EditUserResponse::class)->with([
            'user' => new UserResource($user->load('roles')),
        ]);
    }

    public function update(
        ValidateUpdateUser $request,
        UpdateUserManager $action,
        User $user
    ) {
        $user = $action->execute($user, $request);

        event(new UserUpdatedByAdmin($user));

        return back()->withToast("{$user->name}'s account was updated.");
    }

    public function destroy(DeleteUser $action, User $user)
    {
        $user = $action->execute($user);

        event(new UserDeletedByAdmin($user));

        return redirect()
            ->route('users.index')
            ->withToast("{$user->name}'s account was deleted.");
    }
}
