<?php

declare(strict_types=1);

namespace Nova\Users\Providers;

use Nova\DomainServiceProvider;
use Nova\Users\Controllers\ForcePasswordResetController;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Livewire\ManageUsers;
use Nova\Users\Livewire\UserNotifications;
use Nova\Users\Livewire\UsersCollector;
use Nova\Users\Livewire\UsersDropdown;
use Nova\Users\Models\User;
use Nova\Users\Policies\UserPolicy;
use Nova\Users\Responses\CreateUserResponse;
use Nova\Users\Responses\DeactivateUserResponse;
use Nova\Users\Responses\DeleteUserResponse;
use Nova\Users\Responses\ShowAllUsersResponse;
use Nova\Users\Responses\ShowUserResponse;
use Nova\Users\Responses\UpdateUserResponse;
use Nova\Users\Spotlight\CreateUser;
use Nova\Users\Spotlight\ViewUser;

class UserServiceProvider extends DomainServiceProvider
{
    protected array $listeners = [
        UserCreatedByAdmin::class => [
            GeneratePassword::class,
        ],
    ];

    protected array $livewireComponents = [
        'users:collector' => UsersCollector::class,
        'users:dropdown' => UsersDropdown::class,
        'users:manage-users' => ManageUsers::class,
        'users:notifications' => UserNotifications::class,
    ];

    protected array $morphMaps = [
        'users' => User::class,
    ];

    protected array $policies = [
        User::class => UserPolicy::class,
    ];

    protected array $responsables = [
        CreateUserResponse::class,
        DeactivateUserResponse::class,
        DeleteUserResponse::class,
        UpdateUserResponse::class,
        ShowAllUsersResponse::class,
        ShowUserResponse::class,
    ];

    protected array $routes = [
        'users/force-password-reset/{user}' => [
            'verb' => 'put',
            'uses' => ForcePasswordResetController::class,
            'as' => 'users.force-password-reset',
        ],
    ];

    public function spotlightCommands(): array
    {
        return [
            CreateUser::class,
            ViewUser::class,
        ];
    }
}
