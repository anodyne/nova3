<?php

namespace Nova\Themes\Providers;

use Nova\Themes\Models\Theme;
use Nova\DomainServiceProvider;
use Nova\Themes\Policies\ThemePolicy;
use Themes\Pulsar\Theme as PulsarTheme;
use Nova\Themes\Console\Commands\ThemeMakeCommand;
use Nova\Themes\Http\Responses\CreateThemeResponse;
use Nova\Themes\Http\Responses\UpdateThemeResponse;
use Nova\Themes\Http\Responses\ShowAllThemesResponse;
use Nova\Themes\Http\Responses\DeleteThemeConfirmationResponse;

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
        DeleteThemeConfirmationResponse::class,
        UpdateThemeResponse::class,
        ShowAllThemesResponse::class,
    ];

    protected function bootActions()
    {
        $theme = new PulsarTheme;

        $this->app->instance('nova.theme', $theme);

        $this->app->extend('nova.data.frontend', function ($data) use ($theme) {
            $data->put('theme', $theme);

            return $data;
        });
    }
}
