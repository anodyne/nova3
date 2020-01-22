<?php

namespace Nova\Roles\Providers;

use Nova\Roles\Models\Role;
use Nova\DomainServiceProvider;
use Nova\Roles\Policies\RolePolicy;
use Nova\Roles\Http\Responses\EditRoleResponse;
use Nova\Roles\Http\Responses\ViewRoleResponse;
use Nova\Roles\Http\Responses\RoleIndexResponse;
use Nova\Roles\Http\Responses\CreateRoleResponse;
use Nova\Roles\Http\Controllers\SearchRolesController;
use Nova\Roles\Http\Controllers\SearchPermissionsController;

class RoleServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    protected $responsables = [
        CreateRoleResponse::class,
        EditRoleResponse::class,
        RoleIndexResponse::class,
        ViewRoleResponse::class,
    ];

    protected $routes = [
        'permissions/search' => [
            'verb' => 'get',
            'uses' => SearchPermissionsController::class,
            'as' => 'permissions.search',
        ],
        'roles/search' => [
            'verb' => 'get',
            'uses' => SearchRolesController::class,
            'as' => 'roles.search',
        ],
    ];
}
