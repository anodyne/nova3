<?php

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Settings\Models\Settings;
use Nova\Settings\Responses\SettingsResponse;

class SettingsServiceProvider extends DomainServiceProvider
{
    protected $responsables = [
        SettingsResponse::class,
    ];

    protected function bootingDomain()
    {
        $this->app->singleton('nova.settings', function ($app) {
            return Settings::custom()->first();
        });
    }
}
