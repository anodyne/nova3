<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Models\Role;

class DuplicateRoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Role $original)
    {
        $this->authorize('duplicate', $original);

        $role = DuplicateRole::run($original);

        RoleDuplicated::dispatch($role, $original);

        return redirect()
            ->route('roles.edit', $role)
            ->withToast("{$original->display_name} role has been duplicated");
    }
}
