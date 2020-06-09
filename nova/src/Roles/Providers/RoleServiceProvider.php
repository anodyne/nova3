<?php

namespace Nova\Roles\Providers;

use Nova\Roles\Models\Role;
use Nova\DomainServiceProvider;
use Nova\Roles\Policies\RolePolicy;
use Nova\Roles\Http\Responses\ShowRoleResponse;
use Nova\Roles\Http\Responses\CreateRoleResponse;
use Nova\Roles\Http\Responses\UpdateRoleResponse;
use Nova\Roles\Http\Responses\ShowAllRolesResponse;
use Nova\Roles\Http\Controllers\SearchRolesController;
use Nova\Roles\Http\Controllers\SearchPermissionsController;
use Nova\Roles\Http\Responses\DeleteRoleResponse;

class RoleServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    protected $responsables = [
        CreateRoleResponse::class,
        DeleteRoleResponse::class,
        UpdateRoleResponse::class,
        ShowAllRolesResponse::class,
        ShowRoleResponse::class,
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
