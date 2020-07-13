<?php

namespace Nova\Roles\Controllers;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Nova\Roles\Actions\ReorderRoles;
use Nova\Foundation\Controllers\Controller;

class ReorderRolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderRoles $action)
    {
        $this->authorize('update', new Role);

        $action->execute($request->sort);

        return redirect()
            ->route('roles.index')
            ->withToast('Role sort order has been updated');
    }
}
