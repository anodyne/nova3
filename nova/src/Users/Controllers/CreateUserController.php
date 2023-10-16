<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\CreateUserManager;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Requests\CreateUserRequest;
use Nova\Users\Responses\CreateUserResponse;

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

        return CreateUserResponse::send();
    }

    public function store(CreateUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = CreateUserManager::run($request);

        UserCreatedByAdmin::dispatch($user);

        $redirect = redirect()
            ->notify("An account for {$user->name} was created", 'The user has been notified of their account and their password.');

        if (Gate::allows('update', $user)) {
            return $redirect->route('users.edit', $user);
        }

        return $redirect->route('users.index');
    }
}
