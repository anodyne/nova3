<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

trait HandlesMigration
{
    public bool $isMigrating = false;

    public ?bool $useSameDatabase = null;

    public function bootHandlesMigration(): void
    {
        $this->isMigrating = request()->is('setup/migrate*');
    }

    public function getShouldShowDatabaseOptionsProperty(): bool
    {
        return $this->status === null && $this->isMigrating && $this->useSameDatabase === null;
    }

    public function useSameDatabaseForMigration(): void
    {
        $this->host = config('database.connections.mysql.host');
        $this->port = config('database.connections.mysql.port');
        $this->database = config('database.connections.mysql.database');
        $this->username = config('database.connections.mysql.username');
        $this->password = config('database.connections.mysql.password');
        $this->prefix = 'nova_';
        $this->socket = config('database.connections.mysql.socket', '');
        $this->useSameDatabase = true;
    }

    public function useDifferentDatabaseForMigration(): void
    {
        $this->host = config('database.connections.mysql.host');
        $this->port = config('database.connections.mysql.port');
        $this->username = config('database.connections.mysql.username');
        $this->password = config('database.connections.mysql.password');
        $this->prefix = 'nova_';
        $this->socket = config('database.connections.mysql.socket', '');
        $this->useSameDatabase = false;
    }
}
