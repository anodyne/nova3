<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Users\Models\User;
use Nova\Users\Responses\ShowAllUsersResponse;
use Nova\Users\Responses\ShowUserResponse;

class ShowUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all()
    {
        $this->authorize('viewAny', User::class);

        return ShowAllUsersResponse::send();
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return ShowUserResponse::sendWith([
            'user' => $user->load('roles', 'logins'),
        ]);
    }
}
