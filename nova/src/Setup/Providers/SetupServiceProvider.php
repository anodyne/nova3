<?php

namespace Nova\Setup\Providers;

use Nova\DomainServiceProvider;
use Nova\Setup\Console\Commands\RefreshNovaCommand;

class SetupServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        RefreshNovaCommand::class,
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
