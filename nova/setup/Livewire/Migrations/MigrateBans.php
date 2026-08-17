<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Nova\Setup\Actions\Migration\MigrateBan;
use Nova\Setup\Models\Upgrade;
use Nova\Users\Models\Ban;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateBans extends MigrationStep
{
    public string $label = 'Bans';

    public function handleMigration(): void
    {
        $this->query()
            ->whereNotIn('ban_id', Upgrade::type('ban')->pluck('old_id'))
            ->chunkById(100, function (Collection $legacyBans) {
                foreach ($legacyBans as $legacyBan) {
                    MigrateBan::run($legacyBan);
                }
            }, 'ban_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Ban::count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('bans');
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($ban) => MigrateBan::makeJob($ban));
    }
}
