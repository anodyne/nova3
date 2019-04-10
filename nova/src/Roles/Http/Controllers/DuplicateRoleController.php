<?php

namespace Nova\Roles\Http\Controllers;

use Nova\Roles\Jobs;
use Nova\Roles\Events;
use Nova\Roles\Http\Authorizers;
use Silber\Bouncer\Database\Role;
use Nova\Foundation\Http\Controllers\Controller;

class DuplicateRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Authorizers\Duplicate $auth, Role $originalRole)
    {
        $role = dispatch_now(new Jobs\DuplicateRole($originalRole));

        event(new Events\RoleDuplicated($role, $originalRole));

        return $role->fresh();
    }
}
