<?php

namespace Nova\Roles\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Roles\Models\Permission;
use Nova\Foundation\Http\Controllers\Controller;

class SearchPermissionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $permissions = Permission::orderBy('display_name')
            ->filter($request->only('search'))
            ->get();

        return response()->json($permissions, 200);
    }
}
