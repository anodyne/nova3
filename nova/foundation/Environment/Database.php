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
            $pdo = DB::connection()->getPdo();

            $this->version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);

            if (str($this->version)->contains('mariadb', ignoreCase: true)) {
                $this->driver = 'mariadb';
                $this->hasMysql = false;
            } else {
                $this->driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
                $this->hasMysql = in_array('mysql', PDO::getAvailableDrivers());
            }
        } catch (Throwable $th) {
            //throw $th;
            $this->hasMysql = in_array('mysql', PDO::getAvailableDrivers());
        }
    }

    public function driverName(): string
    {
        return match ($this->driver) {
            'mysql' => 'MySQL',
            'mariadb' => 'MariaDB',
            'pgsql' => 'Postgres',
            'sqlsrv' => 'SQL Server',
            'sqlite' => 'SQLite',
            default => 'unknown'
        };
    }

    public function versionNumber(): string
    {
        return str($this->version)->before('-')->toString();
    }

    public function platform(): string
    {
        return sprintf('%s %s', $this->driverName(), $this->versionNumber());
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
