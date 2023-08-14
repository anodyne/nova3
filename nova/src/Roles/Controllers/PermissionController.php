<?php

declare(strict_types=1);

namespace Nova\Roles\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Roles\Models\Permission;
use Nova\Roles\Responses\ListPermissionsResponse;

class PermissionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Permission::class);
    }

    public function index()
    {
        return ListPermissionsResponse::send();
    }
}
