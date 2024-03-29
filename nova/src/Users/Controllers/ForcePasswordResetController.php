<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Models\User;

class ForcePasswordResetController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(User $user)
    {
        $this->authorize('force-password-reset', $user);

        ForcePasswordReset::run($user);

        return back()
            ->notify("Password reset initiated for {$user->name}", 'The user will be forced to reset their password the next time they sign in.');
    }
}
