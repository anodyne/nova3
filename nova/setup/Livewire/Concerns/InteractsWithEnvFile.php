<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Dotenv\Dotenv;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\App;
use Nova\Setup\Enums\DatabaseConfigStatus;

trait InteractsWithEnvFile
{
    protected function writeEnvironmentFile(): void
    {
        if ($this->checkEnvIsWritable()) {
            $path = base_path('.env');

            if (file_exists($path)) {
                $keyPrefix = $this->isMigrating ? 'DB_NOVA2_' : 'DB_';
                $connection = $this->isMigrating ? 'nova2' : 'mysql';

                $keys = [
                    $keyPrefix.'HOST' => $this->host,
                    $keyPrefix.'PORT' => $this->port,
                    $keyPrefix.'DATABASE' => $this->database,
                    $keyPrefix.'USERNAME' => $this->username,
                    $keyPrefix.'PASSWORD' => $this->password,
                    $keyPrefix.'PREFIX' => $this->prefix,
                    $keyPrefix.'SOCKET' => $this->socket,
                ];

                foreach ($keys as $key => $value) {
                    $write = file_put_contents($path, str_replace(
                        "{$key}=", "{$key}=".$value, file_get_contents($path)
                    ));

                    if ($write === 0 || $write == false) {
                        $this->status = DatabaseConfigStatus::failedToWriteEnv;

                        return;
                    }
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
            $this->status = DatabaseConfigStatus::failedToWriteEnv;
        }
    }

    protected function checkEnvIsWritable(): bool
    {
        $path = base_path('.env');

        if (! file_exists($path)) {
            copy(nova_path('.env.example'), $path);

            $this->refreshEnvVars();
        }

        return is_writable($path);
    }

    protected function refreshEnvVars()
    {
        DotEnv::create(Env::getRepository(), App::environmentPath(), App::environmentFile())->load();
    }

    public function getCodeForEnvProperty(): string
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
