<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Nova\Setup\Actions\Migration\MigrateMissionGroup;
use Nova\Setup\Models\Legacy\MissionGroup as LegacyMissionGroup;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Story;

class MigrateMissionGroups extends MigrationStep
{
    public string $label = 'Mission groups';

    public function handleMigration(): void
    {
        $this->query()
            ->whereNotIn('misgroup_id', Upgrade::type('mission-group')->pluck('old_id'))
            ->chunkById(100, function (Collection $missionGroups) {
                foreach ($missionGroups as $missionGroup) {
                    MigrateMissionGroup::run(model: $missionGroup);
                }
            }, 'misgroup_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyMissionGroup::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Story::whereNull('parent_id')->count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('mission_groups');
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($missionGroup) => MigrateMissionGroup::makeJob($missionGroup));
    }
}
