<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Colors\ColorManager;
use Nova\DomainServiceProvider;
use Nova\Foundation\Nova;
use Nova\Setup\Commands\RefreshNovaCommand;

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
            RefreshNovaCommand::class,
        ];
    }

    public function routes(): array
    {
        return [
            'setup' => [
                'verb' => 'get',
                'uses' => 'Nova\Setup\Controllers\SetupController@index',
            ],
            'setup/install' => [
                'verb' => 'post',
                'uses' => 'Nova\Setup\Controllers\SetupController@install',
            ],
        ];
    }
}
