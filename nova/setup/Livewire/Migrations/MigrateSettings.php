<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Nova\Setup\Actions\Migration\MigrateGameSettings;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateSettings extends MigrationStep
{
    public string $label = 'Settings';

    public function handleMigration(): void
    {
        MigrateGameSettings::run();
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return 0;
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return 0;
    }

    protected function getBatchJobs(): Collection
    {
        return collect([
            MigrateGameSettings::makeJob(),
        ]);
    }
}
