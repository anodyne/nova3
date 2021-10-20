<?php

declare(strict_types=1);

namespace Nova\Users\Providers;

use Nova\DomainServiceProvider;
use Nova\Users\Controllers\ForcePasswordResetController;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Livewire\DarkModeToggle;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\SelectUsersModal;
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
    public function eventListeners(): array
    {
        return [
            UserCreatedByAdmin::class => [
                GeneratePassword::class,
            ],
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'users:collector' => UsersCollector::class,
            'users:dark-mode-toggle' => DarkModeToggle::class,
            'users:dropdown' => UsersDropdown::class,
            'users:manage-characters' => ManageCharacters::class,
            'users:manage-roles' => ManageRoles::class,
            'users:notifications' => UserNotifications::class,
            'users:select-users-modal' => SelectUsersModal::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'user' => User::class,
        ];
    }

    public function policies(): array
    {
        return [
            User::class => UserPolicy::class,
        ];
    }

    public function routes(): array
    {
        return [
            'users/force-password-reset/{user}' => [
                'verb' => 'put',
                'uses' => ForcePasswordResetController::class,
                'as' => 'users.force-password-reset',
            ],
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            CreateUser::class,
            ViewUser::class,
        ];
    }
}
