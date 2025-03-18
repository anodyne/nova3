<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Nova\Setup\Actions\Migration\MigrateMission;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Story;

class MigrateMissions extends MigrationStep
{
    public string $label = 'Missions';

    public function handleMigration(): void
    {
        $missionGroupMap = Upgrade::type('mission-group')->get();

        $this->query()
            ->whereNotIn('mission_id', Upgrade::type('mission')->pluck('old_id'))
            ->chunkById(100, function (Collection $missions) use ($missionGroupMap) {
                foreach ($missions as $mission) {
                    MigrateMission::run(
                        model: $mission,
                        missionGroups: $missionGroupMap
                    );
                }
            }, 'mission_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Story::count() - Upgrade::type('mission-group')->count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('missions');
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($mission) => MigrateMission::makeJob($mission));
    }
}
