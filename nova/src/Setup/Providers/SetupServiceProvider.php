<?php

namespace Nova\Setup\Providers;

use Nova\DomainServiceProvider;
use Nova\Setup\Console\Commands\RefreshNovaCommand;

class SetupServiceProvider extends DomainServiceProvider
{
    protected $commands = [
        RefreshNovaCommand::class,
    ];
}
