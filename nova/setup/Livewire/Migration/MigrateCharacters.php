<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Nova\Characters\Models\Character;
use Nova\Setup\Models\Legacy\Character as LegacyCharacter;

class MigrateCharacters extends MigrationStep
{
    public string $label = 'Characters';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    public function getPendingMigrationCountProperty(): int
    {
        return LegacyCharacter::count();
    }

    public function getCompletedMigrationCountProperty(): int
    {
        return Character::count();
    }
}
