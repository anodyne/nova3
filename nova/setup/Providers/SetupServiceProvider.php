<?php

namespace Nova\Setup\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Nova\DomainServiceProvider;
use Nova\Setup\Actions\EnsureDatabaseState;
use Nova\Setup\Commands\RefreshNovaCommand;

class SetupServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        RefreshNovaCommand::class,
        EnsureDatabaseState::class,
    ];

    protected $listeners = [
        MigrationsEnded::class => [
            EnsureDatabaseState::class,
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
