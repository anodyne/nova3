<?php

declare(strict_types=1);

namespace Nova\Users\Providers;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Lab404\Impersonate\Events\LeaveImpersonation;
use Lab404\Impersonate\Events\TakeImpersonation;
use Nova\DomainServiceProvider;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners;
use Nova\Users\Livewire\ActivateUserButton;
use Nova\Users\Livewire\AdminThemeToggle;
use Nova\Users\Livewire\DeactivateUserButton;
use Nova\Users\Livewire\DeleteMyAccount;
use Nova\Users\Livewire\ForcePasswordResetButton;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\MyAccountInfo;
use Nova\Users\Livewire\MyAccountPreferences;
use Nova\Users\Livewire\UserNotificationPreferencesList;
use Nova\Users\Livewire\UserNotifications;
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
            Authenticated::class => [
                Listeners\CheckForForcedPasswordReset::class,
            ],
            Login::class => [
                Listeners\RecordLoginTime::class,
            ],
            UserCreatedByAdmin::class => [
                Listeners\GeneratePassword::class,
            ],
            LeaveImpersonation::class => [
                Listeners\LogImpersonationEnd::class,
            ],
            TakeImpersonation::class => [
                Listeners\LogImpersonationStart::class,
            ],
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'users-admin-theme-toggle' => AdminThemeToggle::class,
            'users-list' => UsersList::class,
            'users-manage-characters' => ManageCharacters::class,
            'users-manage-roles' => ManageRoles::class,
            'users-notifications' => UserNotifications::class,
            'users-activate-button' => ActivateUserButton::class,
            'users-deactivate-button' => DeactivateUserButton::class,
            'users-force-password-reset-button' => ForcePasswordResetButton::class,
            'profile-notification-preferences' => UserNotificationPreferencesList::class,
            'my-account-info' => MyAccountInfo::class,
            'my-account-preferences' => MyAccountPreferences::class,
            'delete-my-account' => DeleteMyAccount::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'user' => User::class,
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
