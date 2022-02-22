<?php

declare(strict_types=1);

namespace Nova\Users\Providers;

use Nova\DomainServiceProvider;
use Nova\Users\Controllers\ForcePasswordResetController;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Livewire\AdminThemeToggle;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\SelectUsersModal;
use Nova\Users\Livewire\UserNotifications;
use Nova\Users\Livewire\UsersCollector;
use Nova\Users\Livewire\UsersDropdown;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;
use Nova\Users\Spotlight\AddUser;
use Nova\Users\Spotlight\EditUser;
use Nova\Users\Spotlight\ViewUser;
use Nova\Users\Spotlight\ViewUsers;

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
            'users:admin-theme-toggle' => AdminThemeToggle::class,
            'users:dropdown' => UsersDropdown::class,
            'users:list' => UsersList::class,
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
            AddUser::class,
            EditUser::class,
            ViewUser::class,
            ViewUsers::class,
        ];
    }
}
