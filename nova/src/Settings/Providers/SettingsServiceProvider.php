<?php

declare(strict_types=1);

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Settings\Livewire\FontSelector;
use Nova\Settings\Livewire\ManageGlobalReviewers;
use Nova\Settings\Livewire\NotificationTypesList;
use Nova\Settings\Models\Settings;
use Nova\Settings\Spotlight;

class SettingsServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'settings-font-selector' => FontSelector::class,
            'settings-notification-types-list' => NotificationTypesList::class,
            'settings-manage-global-reviewers' => ManageGlobalReviewers::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'setting' => Settings::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            Spotlight\ViewCharacterSettings::class,
            Spotlight\ViewEmailSettings::class,
            Spotlight\ViewGeneralSettings::class,
            Spotlight\ViewNotificationSettings::class,
            Spotlight\ViewPostingActivitySettings::class,
            Spotlight\ViewRatingsSettings::class,
            Spotlight\ViewApplicationsSettings::class,
            Spotlight\ViewEnvironmentSettings::class,
        ];
    }
}
