<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Foundation\Http\Controllers\Controller;

class SearchUsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $users = User::orderBy('name')
            ->filter($request->only('search'))
            ->get();

        return response()->json($users, 200);
    }
}
