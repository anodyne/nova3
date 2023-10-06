<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Nova\Setup\Models\Legacy\User as LegacyUser;
use Nova\Users\Models\User;

class MigrateUsers extends MigrationStep
{
    public string $label = 'Users';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    public function getPendingMigrationCountProperty(): int
    {
        return LegacyUser::count();
    }

    public function getCompletedMigrationCountProperty(): int
    {
        return User::count();
    }
}
