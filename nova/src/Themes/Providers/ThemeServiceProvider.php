<?php

declare(strict_types=1);

namespace Nova\Themes\Providers;

use Nova\DomainServiceProvider;
use Nova\Foundation\Nova;
use Nova\Themes\Actions\SetupThemeDirectory;
use Themes\pulsar\Theme as PulsarTheme;

class ThemeServiceProvider extends DomainServiceProvider
{
    public function consoleCommands(): array
    {
        return [
            SetupThemeDirectory::class,
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
