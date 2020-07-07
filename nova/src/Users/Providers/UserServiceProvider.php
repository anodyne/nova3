<?php

namespace Nova\Users\Providers;

use Nova\Users\Models\User;
use Nova\DomainServiceProvider;
use Nova\Users\Policies\UserPolicy;
use Nova\Users\Livewire\ManageUsers;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Livewire\UserUploadAvatar;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Livewire\UserNotifications;
use Nova\Users\Responses\ShowUserResponse;
use Nova\Users\Responses\CreateUserResponse;
use Nova\Users\Responses\DeleteUserResponse;
use Nova\Users\Responses\UpdateUserResponse;
use Nova\Users\Responses\ShowAllUsersResponse;
use Nova\Users\Controllers\ForcePasswordResetController;
use Nova\Users\Responses\DeactivateUserResponse;

class UserServiceProvider extends DomainServiceProvider
{
    protected $listeners = [
        UserCreatedByAdmin::class => [
            GeneratePassword::class,
        ],
    ];

    protected $livewireComponents = [
        'users:manage-users' => ManageUsers::class,
        'users:notifications' => UserNotifications::class,
        'users:upload-avatar' => UserUploadAvatar::class,
    ];

    protected $morphMaps = [
        'users' => User::class,
    ];

    protected $policies = [
        User::class => UserPolicy::class,
    ];

    protected $responsables = [
        CreateUserResponse::class,
        DeactivateUserResponse::class,
        DeleteUserResponse::class,
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
    ];
}
