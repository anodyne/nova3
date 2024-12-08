<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Nova\Foundation\Nova;

class MigrateNovaData extends Step
{
    public function incompleteIcon(): string
    {
        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" /><path d="M4 6v6c0 1.657 3.582 3 8 3c.856 0 1.68 -.05 2.454 -.144m5.546 -2.856v-6" /><path d="M4 12v6c0 1.657 3.582 3 8 3c.171 0 .341 -.002 .51 -.006" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" />';
    }

    public function title(): string
    {
        return 'Migrate my Nova 2 data';
    }

    public function isComplete(): bool
    {
        return filled(Config::get('database.connections.mysql.username'));
    }

    public function isCurrent(): bool
    {
        return Request::is('setup/migrate');
    }

    public function shouldShow(): bool
    {
        return Request::is('setup/migrate*') || Nova::databaseIsConfigured('nova2');
    }
}
