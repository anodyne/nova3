<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Livewire\Attributes\Computed;
use Nova\Foundation\EnvWriter;
use Nova\Setup\Enums\DatabaseConfigStatus;

trait InteractsWithEnvFile
{
    protected function writeEnvironmentFile(): void
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $keyPrefix = $this->isMigrating ? 'DB_NOVA2_' : 'DB_';
                $connection = $this->isMigrating ? 'nova2' : 'mysql';

                $write = $envWriter->write([
                    $keyPrefix.'HOST' => $this->host,
                    $keyPrefix.'PORT' => $this->port,
                    $keyPrefix.'DATABASE' => $this->database,
                    $keyPrefix.'USERNAME' => $this->username,
                    $keyPrefix.'PASSWORD' => $this->password,
                    $keyPrefix.'PREFIX' => $this->prefix,
                    $keyPrefix.'SOCKET' => $this->socket,
                ]);

                if (! $write) {
                    $this->status = DatabaseConfigStatus::FailedToWriteEnv;

                    return;
                }

                config([
                    "database.connections.{$connection}.host" => $this->host,
                    "database.connections.{$connection}.port" => $this->port,
                    "database.connections.{$connection}.database" => $this->database,
                    "database.connections.{$connection}.username" => $this->username,
                    "database.connections.{$connection}.password" => $this->password,
                    "database.connections.{$connection}.prefix" => $this->prefix,
                    "database.connections.{$connection}.socket" => $this->socket,
                ]);
            }
        } else {
            $this->status = DatabaseConfigStatus::FailedToWriteEnv;
        }
    }

    #[Computed]
    public function codeForEnv(): string
    {
        $keyPrefix = $this->isMigrating ? 'DB_NOVA2_' : 'DB_';

        return <<<EOT
        {$keyPrefix}CONNECTION=mysql
        {$keyPrefix}HOST={$this->host}
        {$keyPrefix}PORT={$this->port}
        {$keyPrefix}DATABASE={$this->database}
        {$keyPrefix}USERNAME={$this->username}
        {$keyPrefix}PASSWORD={$this->password}
        {$keyPrefix}PREFIX={$this->prefix}
        {$keyPrefix}SOCKET={$this->socket}
        EOT;
    }
}
