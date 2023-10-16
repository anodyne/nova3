<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\DeleteUserManager;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Users\Models\User;
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

        return DeleteUserResponse::sendWith([
            'user' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user = DeleteUserManager::run($user);

        UserDeletedByAdmin::dispatch($user);

        return redirect()
            ->route('users.index')
            ->notify("{$user->name}'s account was deleted");
    }
}
