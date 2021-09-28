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
    public function consoleCommands(): array
    {
        return [
            SetupThemeDirectory::class,
        ];
    }

    public function policies(): array
    {
        return [
            Theme::class => ThemePolicy::class,
        ];
    }

    public function responsables(): array
    {
        return [
            CreateThemeResponse::class,
            DeleteThemeResponse::class,
            UpdateThemeResponse::class,
            ShowAllThemesResponse::class,
        ];
    }

    public function domainBooted(): void
    {
        if (Nova::isInstalled()) {
            $theme = new PulsarTheme();

            $this->app->instance('nova.theme', $theme);
        }
    }
}
