<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\UpdateUserManager;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Requests\UpdateUserRequest;
use Nova\Users\Responses\UpdateUserResponse;

class UpdateUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return UpdateUserResponse::sendWith([
            'user' => $user->load('roles', 'characters'),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user = UpdateUserManager::run($user, $request);

        UserUpdatedByAdmin::dispatch($user);

        return back()->notify("{$user->name}'s account was updated");
    }
}
