<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

use Illuminate\Support\Facades\DB;
use PDO;
use Throwable;

readonly class Database
{
    public string $driver;

    public string $version;

    public bool $hasMysql;

    public function __construct()
    {
        try {
            $pdo = DB::connection()->getPdo();

            $version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);

            if (str($version)->contains('mariadb', ignoreCase: true)) {
                $driver = 'mariadb';
                $hasMysql = false;
            } else {
                $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
                $hasMysql = $driver === 'mysql'
                    && in_array('mysql', PDO::getAvailableDrivers());
            }
        } catch (Throwable $th) {
            report($th);

            $driver = 'unknown';
            $version = 'unknown';
            $hasMysql = in_array('mysql', PDO::getAvailableDrivers());
        }

        $this->driver = $driver;
        $this->version = $version;
        $this->hasMysql = $hasMysql;
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

    public function versionFor(string $driver): ?string
    {
        return match ($driver) {
            'mysql' => '8.0+',
            'mariadb' => '10.2.7+',
            'pgsql' => '13.0+',
            default => null
        };
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
        return match ($this->driver) {
            'mysql' => version_compare($this->version, '8.0', '>='),
            'mariadb' => version_compare($this->version, '10.2.7', '>='),
            'pgsql' => version_compare($this->version, '13.0', '>='),
            'unknown' => true,
            default => false,
        };
    }

    public function passesDriver(): bool
    {
        return match ($this->driver) {
            'mysql' => true,
            'mariadb' => true,
            'pgsql' => true,
            default => false
        };
    }

    public function passesVersion(): bool
    {
        if ($this->driver === 'unknown') {
            return false;
        }

        return $this->passes();
    }

    public function isMysql(): bool
    {
        return $this->driver === 'mysql';
    }
}
