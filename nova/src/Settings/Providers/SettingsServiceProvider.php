<?php

declare(strict_types=1);

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Foundation\Nova;
use Nova\Settings\Actions\UpdateAppearance;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\General;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Data\SettingInfo;
use Nova\Settings\Livewire\FindSettingsModal;
use Nova\Settings\Livewire\NotificationSetting;
use Nova\Settings\Models\Settings;
use Nova\Settings\Responses\AppearanceSettingsResponse;
use Nova\Settings\Responses\CharactersSettingsResponse;
use Nova\Settings\Responses\EmailSettingsResponse;
use Nova\Settings\Responses\GeneralSettingsResponse;
use Nova\Settings\Responses\MetaTagsSettingsResponse;
use Nova\Settings\Responses\NotificationSettingsResponse;
use Nova\Settings\Responses\PostingActivitySettingsResponse;
use Nova\Settings\Responses\RatingsSettingsResponse;
use Nova\Settings\SettingsManager;
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
            'settings:notification-setting' => NotificationSetting::class,
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

    public function domainBooting(): void
    {
        $this->app->singleton(SettingsManager::class, function ($app) {
            $manager = new SettingsManager();

            $manager->add('characters', new SettingInfo(
                dto: Characters::class,
                response: CharactersSettingsResponse::class,
                action: null,
            ));
            $manager->add('notifications', new SettingInfo(
                dto: Discord::class,
                response: NotificationSettingsResponse::class
            ));
            $manager->add('email', new SettingInfo(
                dto: Email::class,
                response: EmailSettingsResponse::class
            ));
            $manager->add('general', new SettingInfo(
                dto: General::class,
                response: GeneralSettingsResponse::class
            ));
            $manager->add('meta-tags', new SettingInfo(
                dto: MetaTags::class,
                response: MetaTagsSettingsResponse::class
            ));
            $manager->add('posting-activity', new SettingInfo(
                dto: PostingActivity::class,
                response: PostingActivitySettingsResponse::class
            ));
            $manager->add('appearance', new SettingInfo(
                dto: Appearance::class,
                response: AppearanceSettingsResponse::class,
                action: UpdateAppearance::class,
            ));
            $manager->add('ratings', new SettingInfo(
                dto: ContentRatings::class,
                response: RatingsSettingsResponse::class,
            ));

            return $manager;
        });
    }
}
