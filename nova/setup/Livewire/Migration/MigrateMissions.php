<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Setup\Models\Legacy\Mission as LegacyMission;
use Nova\Setup\Models\Legacy\MissionGroup as LegacyMissionGroup;
use Nova\Stories\Models\Story;

class MigrateMissions extends MigrationStep
{
    public string $label = 'Mission groups & missions';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyMissionGroup::count() + LegacyMission::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Story::count();
    }
}
