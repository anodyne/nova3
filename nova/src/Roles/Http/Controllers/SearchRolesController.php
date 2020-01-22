<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Foundation\Http\Controllers\Controller;

class SearchRolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $roles = Role::orderBy('display_name')
            ->filter($request->only('search'))
            ->get();

        return response()->json($roles, 200);
    }
}
