<?php

namespace Nova\Users\Providers;

use Nova\Users\Models\User;
use Nova\DomainServiceProvider;
use Nova\Users\Policies\UserPolicy;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Http\Controllers\SearchUsersController;

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

    protected $routes = [
        'users/search' => [
            'verb' => 'get',
            'uses' => SearchUsersController::class,
            'as' => 'users.search',
        ],
    ];
}
