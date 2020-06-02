<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Nova\Users\Actions\UpdateUserManager;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Http\Requests\UpdateUserRequest;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Users\Http\Responses\UpdateUserResponse;

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

        return app(UpdateUserResponse::class)->with([
            'user' => $user->load('roles'),
        ]);
    }

    public function update(
        UpdateUserRequest $request,
        UpdateUserManager $action,
        User $user
    ) {
        $user = $action->execute($user, $request);

        event(new UserUpdatedByAdmin($user));

        return back()->withToast("{$user->name}'s account was updated");
    }
}
