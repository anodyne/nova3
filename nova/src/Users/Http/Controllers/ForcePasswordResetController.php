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

    public function __invoke(
        ForcePasswordReset $forcePasswordReset,
        User $user
    ) {
        $this->authorize('update', $user);

        $forcePasswordReset->execute($user);

        return back()
            ->withToast("{$user->name} will be forced to reset their password next time they sign in.");
    }
}
