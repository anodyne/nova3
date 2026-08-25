<?php

declare(strict_types=1);

namespace Nova\Foundation\Values;

use PDO;
use UnexpectedValueException;

readonly class DatabaseVersionInfo
{
    public bool $isMaria;

    public bool $isMysql;

    public bool $isPostgres;

    public function __construct(
        public string $driver,
        public string $version,
    ) {
        $this->isMaria = $driver === 'mysql' && str_contains($version, 'MariaDB');
        $this->isMysql = $driver === 'mysql' && ! $this->isMaria;
        $this->isPostgres = $driver === 'pgsql';
    }

    public static function fromPdo(PDO $pdo, string $driver): self
    {
        $version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);

        if (! is_int($version) && ! is_string($version)) {
            throw new UnexpectedValueException('Unable to determine the database server version.');
        }

        return new self(
            driver: $driver,
            version: (string) $version,
        );
    }
}
