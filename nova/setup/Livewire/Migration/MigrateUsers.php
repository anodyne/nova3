<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Setup\Models\Legacy\User as LegacyUser;
use Nova\Users\Models\User;

class MigrateUsers extends MigrationStep
{
    public string $label = 'Users';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyUser::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return User::count();
    }
}
