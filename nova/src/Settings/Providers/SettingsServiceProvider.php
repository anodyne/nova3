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
use Nova\Settings\Livewire\ThemeBuilder;
use Nova\Settings\Models\Settings;
use Nova\Settings\Spotlight\ViewApplicationsSettings;
use Nova\Settings\Spotlight\ViewCharacterSettings;
use Nova\Settings\Spotlight\ViewEmailSettings;
use Nova\Settings\Spotlight\ViewGeneralSettings;
use Nova\Settings\Spotlight\ViewNotificationSettings;
use Nova\Settings\Spotlight\ViewPostingActivitySettings;
use Nova\Settings\Spotlight\ViewRatingsSettings;

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
            'settings-theme-builder' => ThemeBuilder::class,
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
            ViewCharacterSettings::class,
            ViewEmailSettings::class,
            ViewGeneralSettings::class,
            ViewNotificationSettings::class,
            ViewPostingActivitySettings::class,
            ViewRatingsSettings::class,
            ViewApplicationsSettings::class,
        ];
    }
}
