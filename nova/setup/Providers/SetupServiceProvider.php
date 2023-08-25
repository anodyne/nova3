<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use Filament\Support\Colors\ColorManager;
use Nova\DomainServiceProvider;
use Nova\Foundation\Colors\Color;
use Nova\Foundation\Nova;
use Nova\Pages\Enums\PageVerb;
use Nova\Setup\Actions\InstallNova;
use Nova\Setup\Actions\SeedRealStories;

class SetupServiceProvider extends DomainServiceProvider
{
    public function domainBooted(): void
    {
        if (! Nova::isInstalled()) {
            app(ColorManager::class)->register(['primary' => Color::Sky]);
        }
    }

    public function consoleCommands(): array
    {
        return [
            SeedRealStories::class,
            InstallNova::class,
        ];
    }

    public function routes(): array
    {
        return [
            'setup' => [
                'verb' => PageVerb::get->value,
                'uses' => 'Nova\Setup\Controllers\SetupController@index',
            ],
            'setup/install' => [
                'verb' => PageVerb::post->value,
                'uses' => 'Nova\Setup\Controllers\SetupController@install',
            ],
        ];
    }
}
