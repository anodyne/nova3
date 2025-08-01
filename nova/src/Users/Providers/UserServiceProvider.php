<?php

declare(strict_types=1);

namespace Nova\Users\Providers;

use Nova\Users\Listeners\CheckForForcedPasswordReset;
use Nova\Users\Listeners\RecordLoginTime;
use Nova\Users\Listeners\GeneratePassword;
use Nova\Users\Listeners\LogImpersonationEnd;
use Nova\Users\Listeners\LogImpersonationStart;
use Nova\Users\Listeners\ClearForcedPasswordResetFlag;
use Nova\Users\Spotlight\AddBan;
use Nova\Users\Spotlight\AddUser;
use Nova\Users\Spotlight\EditUser;
use Nova\Users\Spotlight\ViewUser;
use Nova\Users\Spotlight\ViewBans;
use Nova\Users\Spotlight\ViewUsers;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use Lab404\Impersonate\Events\LeaveImpersonation;
use Lab404\Impersonate\Events\TakeImpersonation;
use Nova\DomainServiceProvider;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Listeners;
use Nova\Users\Livewire\ActivateUserButton;
use Nova\Users\Livewire\BansList;
use Nova\Users\Livewire\DeactivateUserButton;
use Nova\Users\Livewire\DeleteMyAccount;
use Nova\Users\Livewire\ForcePasswordResetButton;
use Nova\Users\Livewire\ManageCharacters;
use Nova\Users\Livewire\ManageRoles;
use Nova\Users\Livewire\MyAccount;
use Nova\Users\Livewire\UserModerationList;
use Nova\Users\Livewire\UserNotificationPreferencesList;
use Nova\Users\Livewire\UserNotifications;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\User;
use Nova\Users\Spotlight;

class UserServiceProvider extends DomainServiceProvider
{
    public function eventListeners(): array
    {
        return [
            Authenticated::class => [
                CheckForForcedPasswordReset::class,
            ],
            Login::class => [
                RecordLoginTime::class,
            ],
            UserCreatedByAdmin::class => [
                GeneratePassword::class,
            ],
            LeaveImpersonation::class => [
                LogImpersonationEnd::class,
            ],
            TakeImpersonation::class => [
                LogImpersonationStart::class,
            ],
            PasswordReset::class => [
                ClearForcedPasswordResetFlag::class,
            ],
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'bans-list' => BansList::class,
            'users-list' => UsersList::class,
            'users-manage-characters' => ManageCharacters::class,
            'users-manage-roles' => ManageRoles::class,
            'users-moderation-list' => UserModerationList::class,
            'users-notifications' => UserNotifications::class,
            'users-activate-button' => ActivateUserButton::class,
            'users-deactivate-button' => DeactivateUserButton::class,
            'users-force-password-reset-button' => ForcePasswordResetButton::class,
            'profile-notification-preferences' => UserNotificationPreferencesList::class,
            'my-account' => MyAccount::class,
            'delete-my-account' => DeleteMyAccount::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'user' => User::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'usr_' => User::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddBan::class,
            AddUser::class,
            EditUser::class,
            ViewUser::class,
            ViewBans::class,
            ViewUsers::class,
        ];
    }
}
