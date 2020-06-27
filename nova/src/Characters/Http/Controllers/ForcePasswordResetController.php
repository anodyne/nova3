<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Foundation\Http\Controllers\Controller;

class ForcePasswordResetController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(ForcePasswordReset $action, User $user)
    {
        $this->authorize('update', $user);

        $action->execute($user);

        return back()
            ->withToast("Password reset initiated for {$user->name}", 'The user will be forced to reset their password the next time they sign in.');
    }
}
