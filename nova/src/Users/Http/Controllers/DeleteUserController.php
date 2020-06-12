<?php

namespace Nova\Users\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Users\Models\User;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Users\Http\Responses\DeleteUserResponse;

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

    public function destroy(DeleteUser $action, User $user)
    {
        $this->authorize('delete', $user);

        $user = $action->execute($user);

        event(new UserDeletedByAdmin($user));

        return redirect()
            ->route('users.index')
            ->withToast("{$user->name}'s account was deleted");
    }
}
