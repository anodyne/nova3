<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Setup\Models\Legacy\News as LegacyNews;

class MigrateNewsItems extends MigrationStep
{
    public string $label = 'News items';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyNews::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return 0;
    }
}
