<?php

namespace Nova\Users\Providers;

use Nova\Users\Models\User;
use Nova\DomainServiceProvider;
use Nova\Users\Policies\UserPolicy;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Http\Responses\EditUserResponse;
use Nova\Users\Http\Responses\ViewUserResponse;
use Nova\Users\Http\Responses\UserIndexResponse;
use Nova\Users\Http\Responses\CreateUserResponse;
use Nova\Users\Http\Controllers\SearchUsersController;
use Nova\Users\Http\Controllers\ForcePasswordResetController;

class UserServiceProvider extends DomainServiceProvider
{
    protected $listeners = [
        UserCreatedByAdmin::class => [
            GeneratePassword::class,
        ],
    ];

    protected $morphMaps = [
        'users' => User::class,
    ];

    protected $policies = [
        User::class => UserPolicy::class,
    ];

    protected $responsables = [
        CreateUserResponse::class,
        EditUserResponse::class,
        UserIndexResponse::class,
        ViewUserResponse::class,
    ];

    protected $routes = [
        'users/force-password-reset/{user}' => [
            'verb' => 'put',
            'uses' => ForcePasswordResetController::class,
            'as' => 'users.force-password-reset',
        ],
        'users/search' => [
            'verb' => 'get',
            'uses' => SearchUsersController::class,
            'as' => 'users.search',
        ],
    ];
}
