<?php

declare(strict_types=1);

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Foundation\Nova;
use Nova\Settings\Models\Settings;
use Nova\Settings\Responses\SettingsResponse;

class SettingsServiceProvider extends DomainServiceProvider
{
    protected array $responsables = [
        SettingsResponse::class,
    ];

    protected function bootingDomain()
    {
        $this->app->singleton('nova.settings', function ($app) {
            if (Nova::isInstalled()) {
                return Settings::custom()->first();
            }

            return new Settings();
        });
    }
}
