<?php

declare(strict_types=1);

namespace Nova\Themes\Providers;

use Nova\DomainServiceProvider;
use Nova\Foundation\Nova;
use Nova\Themes\Actions\SetupThemeDirectory;
use Nova\Themes\Models\Theme;
use Nova\Themes\Policies\ThemePolicy;
use Nova\Themes\Responses\CreateThemeResponse;
use Nova\Themes\Responses\DeleteThemeResponse;
use Nova\Themes\Responses\ShowAllThemesResponse;
use Nova\Themes\Responses\UpdateThemeResponse;
use Themes\pulsar\Theme as PulsarTheme;

class ThemeServiceProvider extends DomainServiceProvider
{
    protected array $commands = [
        SetupThemeDirectory::class,
    ];

    protected array $policies = [
        Theme::class => ThemePolicy::class,
    ];

    protected array $responsables = [
        CreateThemeResponse::class,
        DeleteThemeResponse::class,
        UpdateThemeResponse::class,
        ShowAllThemesResponse::class,
    ];

    protected function bootedDomain()
    {
        if (Nova::isInstalled()) {
            $theme = new PulsarTheme();

            $this->app->instance('nova.theme', $theme);
        }
    }
}
