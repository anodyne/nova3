<?php

namespace Nova\Users\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\Actions\DeleteUserManager;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Responses\DeleteUserResponse;

class DeleteUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $user = User::findOrFail($request->id);

        return app(DeleteUserResponse::class)->with([
            'user' => $user,
        ]);
    }

    public function destroy(DeleteUserManager $action, User $user)
    {
        $this->authorize('delete', $user);

        $user = $action->execute($user);

        UserDeletedByAdmin::dispatch($user);

        return redirect()
            ->route('users.index', "status={$user->status->name()}")
            ->withToast("{$user->name}'s account was deleted");
    }
}
