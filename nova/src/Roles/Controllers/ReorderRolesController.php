<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Actions\ReorderRoles;
use Nova\Roles\Models\Role;

class ReorderRolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderRoles $action)
    {
        $this->authorize('update', new Role());

        $action->execute($request->sort);

        return redirect()
            ->route('roles.index')
            ->withToast('Role sort order has been updated');
    }
}
