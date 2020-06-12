<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Nova\Users\Actions\CreateUser;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Http\Requests\CreateUserRequest;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Models\Role;
use Nova\Users\Actions\CreateUserManager;
use Nova\Users\Http\Responses\CreateUserResponse;

class CreateUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return app(CreateUserResponse::class)->with([
            'defaultRoles' => Role::whereDefault()->get(),
            'user' => auth()->user(),
        ]);
    }

    public function store(CreateUserRequest $request, CreateUserManager $action)
    {
        $user = $action->execute($request);

        event(new UserCreatedByAdmin($user));

        return redirect()
            ->route('users.index')
            ->withToast("An account for {$user->name} was created", 'The user has been notified of their account and their password.');
    }
}
