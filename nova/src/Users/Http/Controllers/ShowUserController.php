<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\Http\Responses\ShowUserResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Users\Filters\UserFilters;
use Nova\Users\Http\Responses\ShowAllUsersResponse;

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
            ->orderBy('name')
            ->filter($filters)
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
            'user' => $user->load('roles'),
        ]);
    }
}
