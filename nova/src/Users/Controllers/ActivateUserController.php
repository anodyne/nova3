<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\ActivateUserManager;
use Nova\Users\Events\UserActivated;
use Nova\Users\Models\User;

class ActivateUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(
        Request $request,
        ActivateUserManager $action,
        User $user
    ) {
        $this->authorize('activate', $user);

        $user = $action->execute($request, $user);

        UserActivated::dispatch($user);

        return redirect()
            ->route('users.index', 'status=active')
            ->withToast("{$user->name} has been activated");
    }
}
