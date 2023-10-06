<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Nova\Departments\Models\Position;
use Nova\Setup\Models\Legacy\Position as LegacyPosition;

class MigratePositions extends MigrationStep
{
    public string $label = 'Positions';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    public function getPendingMigrationCountProperty(): int
    {
        return LegacyPosition::count();
    }

    public function getCompletedMigrationCountProperty(): int
    {
        return Position::count();
    }
}
