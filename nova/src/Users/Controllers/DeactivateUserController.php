<?php

namespace Nova\Users\Controllers;

use Illuminate\Http\Request;
use Nova\Users\Models\User;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Events\UserDeactivated;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Responses\DeactivateUserResponse;

class DeactivateUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $user = User::findOrFail($request->id);

        return app(DeactivateUserResponse::class)->with([
            'user' => $user,
        ]);
    }

    public function deactivate(DeactivateUser $action, User $user)
    {
        $this->authorize('deactivate', $user);

        $user = $action->execute($user);

        UserDeactivated::dispatch($user);

        return redirect()
            ->route('users.index', 'status=active')
            ->withToast("{$user->name} has been deactivated");
    }
}
