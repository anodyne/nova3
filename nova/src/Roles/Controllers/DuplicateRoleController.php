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

    public function __invoke(
        DuplicateRole $action,
        Role $originalRole
    ) {
        $this->authorize('duplicate', $originalRole);

        $role = $action->execute($originalRole);

        RoleDuplicated::dispatch($role, $originalRole);

        return redirect()
            ->route('roles.edit', $role)
            ->withToast("{$originalRole->display_name} role has been duplicated");
    }
}
