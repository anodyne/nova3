<?php

namespace Nova\Users\Controllers;

use Nova\Users\Models\User;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Events\UserDeactivated;
use Nova\Foundation\Controllers\Controller;

class DeactivateUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(DeactivateUser $action, User $user)
    {
        $this->authorize('deactivate', $user);

        $user = $action->execute($user);

        UserDeactivated::dispatch($user);

        return redirect()
            ->route('users.index', 'status=active')
            ->withToast("{$user->name} has been deactivated");
    }
}
