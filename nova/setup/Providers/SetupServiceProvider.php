<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use Nova\DomainServiceProvider;
use Nova\Setup\Commands\RefreshNovaCommand;

class SetupServiceProvider extends DomainServiceProvider
{
    protected array $commands = [
        RefreshNovaCommand::class,
    ];

    protected array $routes = [
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
