<?php

namespace Nova\Themes\Providers;

use Nova\Foundation\Nova;
use Nova\Themes\Models\Theme;
use Nova\DomainServiceProvider;
use Nova\Themes\Policies\ThemePolicy;
use Themes\Pulsar\Theme as PulsarTheme;
use Nova\Themes\Console\Commands\ThemeMakeCommand;
use Nova\Themes\Http\Responses\CreateThemeResponse;
use Nova\Themes\Http\Responses\DeleteThemeResponse;
use Nova\Themes\Http\Responses\UpdateThemeResponse;
use Nova\Themes\Http\Responses\ShowAllThemesResponse;

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
        DeleteThemeResponse::class,
        UpdateThemeResponse::class,
        ShowAllThemesResponse::class,
    ];

    protected function bootedDomain()
    {
        if (Nova::isInstalled()) {
            $theme = new PulsarTheme;

            $this->app->instance('nova.theme', $theme);

            $this->app->extend('nova.data.frontend', function ($data) use ($theme) {
                $data->put('theme', $theme);

                return $data;
            });
        }
    }
}
