<?php

namespace Nova\Users\Providers;

use Nova\Users\Models\User;
use Nova\DomainServiceProvider;
use Nova\Users\Policies\UserPolicy;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Http\Responses\ShowUserResponse;
use Nova\Users\Http\Responses\CreateUserResponse;
use Nova\Users\Http\Responses\UpdateUserResponse;
use Nova\Users\Http\Responses\ShowAllUsersResponse;
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
        UpdateUserResponse::class,
        ShowAllUsersResponse::class,
        ShowUserResponse::class,
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
