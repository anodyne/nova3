<?php

namespace Nova\Themes\Providers;

use Nova\Foundation\Nova;
use Nova\Themes\Models\Theme;
use Nova\DomainServiceProvider;
use Nova\Themes\Policies\ThemePolicy;
use Themes\Pulsar\Theme as PulsarTheme;
use Nova\Themes\Responses\CreateThemeResponse;
use Nova\Themes\Responses\DeleteThemeResponse;
use Nova\Themes\Responses\UpdateThemeResponse;
use Nova\Themes\Responses\ShowAllThemesResponse;
use Nova\Themes\Console\Commands\ThemeMakeCommand;

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
        }
    }
}
