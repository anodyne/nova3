<?php

declare(strict_types=1);

namespace Nova\Themes\Providers;

use Nova\DomainServiceProvider;
use Nova\Foundation\Nova;
use Nova\Themes\Actions\SetupThemeDirectory;
use Nova\Themes\Livewire\ThemeSelector;
use Nova\Themes\Livewire\ThemeSettings;
use Nova\Themes\Livewire\ThemesList;
use Nova\Themes\Models\Theme;

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
            $themeName = strtolower(settings('appearance.theme'));

            $themeNamespace = str($themeName)->studly();

            $themeClass = "Themes\\$themeNamespace\\Theme";

            $theme = new $themeClass();

            $this->app->instance('nova.theme', $theme);

            $this->app['view']->addLocation("themes/{$theme->location}/views");
        } else {
            $this->app->bind('nova.theme', fn () => null);
        }
    }

    public function livewireComponents(): array
    {
        return [
            'theme-selector' => ThemeSelector::class,
            'theme-settings' => ThemeSettings::class,
            'themes-list' => ThemesList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'theme' => Theme::class,
        ];
    }
}
