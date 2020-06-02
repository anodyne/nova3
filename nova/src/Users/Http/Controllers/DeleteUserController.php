<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Foundation\Http\Controllers\Controller;

class DeleteUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(DeleteUser $action, User $user)
    {
        $this->authorize('delete', $user);

        $user = $action->execute($user);

        event(new UserDeletedByAdmin($user));

        return redirect()
            ->route('users.index')
            ->withToast("{$user->name}'s account was deleted");
    }
}
