<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

use Illuminate\Support\Facades\DB;
use PDO;
use Throwable;

class Database
{
    public readonly string $driver;

    public readonly string $version;

    public readonly bool $hasMysql;

    public function __construct()
    {
        try {
            $this->driver = DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
            $this->version = DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);
        } catch (Throwable $th) {
            //throw $th;
        }

        $this->hasMysql = in_array('mysql', PDO::getAvailableDrivers());
    }

    public function driverName(): string
    {
        return match ($this->driver) {
            'mariadb' => 'MariaDB',
            'pgsql' => 'Postgres',
            'sqlsrv' => 'SQL Server',
            'sqlite' => 'SQLite',
            default => 'unknown'
        };
    }

    public function fails(): bool
    {
        return ! $this->passes();
    }

    public function passes(): bool
    {
        return $this->hasMysql;
    }
}
