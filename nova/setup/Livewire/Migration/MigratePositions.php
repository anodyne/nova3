<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Departments\Models\Position;
use Nova\Setup\Models\Legacy\Position as LegacyPosition;

class MigratePositions extends MigrationStep
{
    public string $label = 'Positions';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyPosition::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Position::count();
    }
}
