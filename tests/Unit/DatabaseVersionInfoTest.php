<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Values\DatabaseVersionInfo;

it('identifies the database platform', function (
    string $driver,
    string $version,
    bool $isMaria,
    bool $isMysql,
    bool $isPostgres,
) {
    $versionInfo = new DatabaseVersionInfo($driver, $version);

    expect($versionInfo->driver)->toBe($driver)
        ->and($versionInfo->version)->toBe($version)
        ->and($versionInfo->isMaria)->toBe($isMaria)
        ->and($versionInfo->isMysql)->toBe($isMysql)
        ->and($versionInfo->isPostgres)->toBe($isPostgres);
})->with([
    'MySQL' => ['mysql', '8.4.0', false, true, false],
    'MariaDB' => ['mysql', '11.4.2-MariaDB', true, false, false],
    'Postgres' => ['pgsql', '17.2', false, false, true],
    'SQLite' => ['sqlite', '3.46.1', false, false, false],
]);

it('creates version information from PDO attributes', function () {
    $pdo = new class extends PDO
    {
        public function __construct() {}

        public function getAttribute(int $attribute): string
        {
            expect($attribute)->toBe(PDO::ATTR_SERVER_VERSION);

            return '8.4.0';
        }
    };

    $versionInfo = DatabaseVersionInfo::fromPdo($pdo, 'mysql');

    expect($versionInfo->version)->toBe('8.4.0')
        ->and($versionInfo->isMysql)->toBeTrue();
});

it('rejects an unavailable PDO server version', function () {
    $pdo = new class extends PDO
    {
        public function __construct() {}

        public function getAttribute(int $attribute): false
        {
            return false;
        }
    };

    expect(fn () => DatabaseVersionInfo::fromPdo($pdo, 'mysql'))
        ->toThrow(UnexpectedValueException::class, 'Unable to determine the database server version.');
});

it('returns typed version information from the database macro', function () {
    expect(DB::versionInfo())->toBeInstanceOf(DatabaseVersionInfo::class);
});
