<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

enum NovaMigrateStatus: string
{
    case AlreadyMigrated = 'already-migrated';

    case DatabaseConfigured = 'database-configured';

    case DataMigrated = 'data-migrated';

    case DataPartiallyMigrated = 'data-partially-migrated';

    case Failed = 'failed';

    case Success = 'success';

    case UserAccessUpdated = 'user-access-updated';

    public function isDatabaseConfigured(): bool
    {
        return match ($this) {
            self::AlreadyMigrated => true,
            self::DatabaseConfigured => true,
            self::DataMigrated => true,
            self::DataPartiallyMigrated => true,
            self::UserAccessUpdated => true,
            self::Success => true,
            default => false,
        };
    }

    public function isDataMigrated(): bool
    {
        return match ($this) {
            self::AlreadyMigrated => true,
            self::DataMigrated => true,
            self::DataPartiallyMigrated => true,
            self::Success => true,
            default => false,
        };
    }

    public function isUserAccessUpdated(): bool
    {
        return match ($this) {
            self::AlreadyMigrated, self::UserAccessUpdated, self::Success => true,
            default => false,
        };
    }

    public function isSettingsUpdated(): bool
    {
        return match ($this) {
            self::Success => true,
            default => false,
        };
    }
}
