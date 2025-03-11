<?php

declare(strict_types=1);

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Settings\Livewire\ContentRatingsSettings;
use Nova\Settings\Livewire\EmailSettings;
use Nova\Settings\Livewire\EnvironmentSettings;
use Nova\Settings\Livewire\FontSelector;
use Nova\Settings\Livewire\ManageGlobalReviewers;
use Nova\Settings\Livewire\NotificationTypesList;
use Nova\Settings\Livewire\PostingActivitySettings;
use Nova\Settings\Models\Settings;
use Nova\Settings\Spotlight;

class SettingsServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'settings-content-ratings' => ContentRatingsSettings::class,
            'settings-email' => EmailSettings::class,
            'settings-environment' => EnvironmentSettings::class,
            'settings-font-selector' => FontSelector::class,
            'settings-notification-types-list' => NotificationTypesList::class,
            'settings-manage-global-reviewers' => ManageGlobalReviewers::class,
            'settings-posting-activity' => PostingActivitySettings::class,
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
        ];
    }
}
