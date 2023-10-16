<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Events\UserDeactivated;
use Nova\Users\Models\User;
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

        return DeactivateUserResponse::sendWith([
            'user' => $user,
        ]);
    }

    public function deactivate(User $user)
    {
        $this->authorize('deactivate', $user);

        $user = DeactivateUser::run($user);

        UserDeactivated::dispatch($user);

        return redirect()
            ->route('users.index')
            ->notify("{$user->name} has been deactivated");
    }
}
