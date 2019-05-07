<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Jobs;
use Nova\Roles\Events;
use Nova\Roles\Models\Role;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Roles\Http\Validators\Duplicate as ValidateDuplicatingRole;
use Nova\Roles\Http\Authorizors\Duplicate as AuthorizeDuplicatingRole;

class DuplicateRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(AuthorizeDuplicatingRole $gate, ValidateDuplicatingRole $request, Role $originalRole)
    {
        $role = dispatch_now(new Jobs\Duplicate($originalRole));

        event(new Events\Duplicated($role, $originalRole));

        return $role->fresh();
    }
}
