<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Characters\Models\Character;
use Nova\Setup\Models\Legacy\Character as LegacyCharacter;

class MigrateCharacters extends MigrationStep
{
    public string $label = 'Characters';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyCharacter::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Character::count();
    }
}
