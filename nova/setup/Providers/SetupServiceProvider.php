<?php

namespace Nova\Setup\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Nova\DomainServiceProvider;
use Nova\Setup\Actions\RunDataMigrations;
use Nova\Setup\Commands\FreshNovaCommand;
use Nova\Setup\Commands\RefreshNovaCommand;

class SetupServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        FreshNovaCommand::class,
        RefreshNovaCommand::class,
    ];

    protected $listeners = [
        MigrationsEnded::class => [
            // RunDataMigrations::class,
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
