<?php

declare(strict_types=1);

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Settings\Livewire\FindSettingsModal;
use Nova\Settings\Livewire\FontSelector;
use Nova\Settings\Livewire\NotificationSetting;
use Nova\Settings\Livewire\NotificationTypesList;
use Nova\Settings\Models\Settings;
use Nova\Settings\Spotlight\ViewCharacterSettings;
use Nova\Settings\Spotlight\ViewEmailSettings;
use Nova\Settings\Spotlight\ViewGeneralSettings;
use Nova\Settings\Spotlight\ViewGroupNotificationSettings;
use Nova\Settings\Spotlight\ViewIndividualNotificationSettings;
use Nova\Settings\Spotlight\ViewMetaTagsSettings;
use Nova\Settings\Spotlight\ViewNotificationSettings;
use Nova\Settings\Spotlight\ViewPostingActivitySettings;
use Nova\Settings\Spotlight\ViewRatingsSettings;
use Nova\Settings\Spotlight\ViewSystemDefaultsSettings;

class SettingsServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'settings:find-settings' => FindSettingsModal::class,
            'settings-font-selector' => FontSelector::class,
            'settings:notification-setting' => NotificationSetting::class,
            'settings-notification-types-list' => NotificationTypesList::class,
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
            ViewGroupNotificationSettings::class,
            ViewIndividualNotificationSettings::class,
            ViewMetaTagsSettings::class,
            ViewNotificationSettings::class,
            ViewPostingActivitySettings::class,
            ViewRatingsSettings::class,
            ViewSystemDefaultsSettings::class,
        ];
    }
}
