<?php

namespace Nova\Users\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\Filters\UserFilters;
use Nova\Users\Responses\ShowUserResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Responses\ShowAllUsersResponse;

class ShowUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, UserFilters $filters)
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('media')
            ->withLastLoginAt()
            ->filter($filters)
            ->orderBy('name')
            ->paginate();

        return app(ShowAllUsersResponse::class)->with([
            'search' => $request->search,
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return app(ShowUserResponse::class)->with([
            'user' => $user->load('roles', 'logins'),
        ]);
    }
}
