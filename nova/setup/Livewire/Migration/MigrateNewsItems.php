<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Nova\Setup\Models\Legacy\News as LegacyNews;

class MigrateNewsItems extends MigrationStep
{
    public string $label = 'News items';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    public function getPendingMigrationCountProperty(): int
    {
        return LegacyNews::count();
    }

    public function getCompletedMigrationCountProperty(): int
    {
        return 0;
    }
}
