<?php

namespace Nova\Themes\Providers;

use Nova\Themes\Models\Theme;
use Nova\DomainServiceProvider;
use Nova\Themes\Policies\ThemePolicy;
use Themes\Pulsar\Theme as PulsarTheme;
use Nova\Themes\Http\Responses\EditThemeResponse;
use Nova\Themes\Http\Responses\ViewThemeResponse;
use Nova\Themes\Console\Commands\ThemeMakeCommand;
use Nova\Themes\Http\Responses\ThemeIndexResponse;
use Nova\Themes\Http\Responses\CreateThemeResponse;

class ThemeServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        ThemeMakeCommand::class,
    ];

    protected $policies = [
        Theme::class => ThemePolicy::class,
    ];

    protected $responsables = [
        CreateThemeResponse::class,
        EditThemeResponse::class,
        ThemeIndexResponse::class,
        ViewThemeResponse::class,
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
