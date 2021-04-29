<?php

namespace Nova\Setup\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Nova\DomainServiceProvider;
use Nova\Setup\Commands\RefreshNovaCommand;
use Nova\Setup\Listeners\EnsureDatabaseStateIsLoaded;

class SetupServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        RefreshNovaCommand::class,
    ];

    protected $listeners = [
        MigrationsEnded::class => [
            EnsureDatabaseStateIsLoaded::class,
        ],
    ];

    protected $routes = [
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
