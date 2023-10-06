<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

enum NovaMigrateStatus: string
{
    case alreadyMigrated = 'already-migrated';

    case databaseConfigured = 'database-configured';

    case dataMigrated = 'data-migrated';

    case dataPartiallyMigrated = 'data-partially-migrated';

    case failed = 'failed';

    case success = 'success';

    case userAccessUpdated = 'user-access-updated';

    public function isDatabaseConfigured(): bool
    {
        return match ($this) {
            self::alreadyMigrated => true,
            self::databaseConfigured => true,
            self::dataMigrated => true,
            self::dataPartiallyMigrated => true,
            self::userAccessUpdated => true,
            self::success => true,
            default => false,
        };
    }

    public function isDataMigrated(): bool
    {
        return match ($this) {
            self::alreadyMigrated => true,
            self::dataMigrated => true,
            self::dataPartiallyMigrated => true,
            self::success => true,
            default => false,
        };
    }

    public function isUserAccessUpdated(): bool
    {
        return match ($this) {
            self::alreadyMigrated, self::userAccessUpdated, self::success => true,
            default => false,
        };
    }

    public function isSettingsUpdated(): bool
    {
        return match ($this) {
            self::success => true,
            default => false,
        };
    }
}
