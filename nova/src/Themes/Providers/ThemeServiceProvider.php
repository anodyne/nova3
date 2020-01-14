<?php

namespace Nova\Themes\Providers;

use Nova\Themes\Models\Theme;
use Nova\DomainServiceProvider;
use Nova\Themes\Policies\ThemePolicy;
use Themes\Pulsar\Theme as PulsarTheme;
use Nova\Themes\Console\Commands\ThemeMakeCommand;

class ThemeServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        ThemeMakeCommand::class,
    ];

    protected $policies = [
        Theme::class => ThemePolicy::class,
    ];

    protected function bootActions()
    {
        $theme = new PulsarTheme;

        $this->app->instance('nova.theme', $theme);

        $this->app->extend('nova.data.frontend', function ($data) use ($theme) {
            $data->put('theme', $theme);
            $data->put('icons', $theme->iconMap());

            return $data;
        });
    }
}
