<?php

namespace Nova\Users\Providers;

use Nova\Users\Models\User;
use Nova\DomainServiceProvider;
use Nova\Users\Policies\UserPolicy;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;

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
}
