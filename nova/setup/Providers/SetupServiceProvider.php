<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use Nova\DomainServiceProvider;
use Nova\Setup\Commands\RefreshNovaCommand;

class SetupServiceProvider extends DomainServiceProvider
{
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
