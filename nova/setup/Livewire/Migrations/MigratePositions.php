<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Computed;
use Nova\Departments\Models\Position;
use Nova\Setup\Actions\Migration\MigratePosition;
use Nova\Setup\Models\Upgrade;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigratePositions extends MigrationStep
{
    public string $label = 'Positions';

    public function handleMigration(): void
    {
        $this->truncateTable();

        $departmentsMap = Upgrade::type('department')->get();

        $this->query()
            ->whereNotIn('pos_id', Upgrade::type('position')->pluck('old_id'))
            ->chunkById(100, function (Collection $legacyPositions) use ($departmentsMap) {
                foreach ($legacyPositions as $legacyPosition) {
                    MigratePosition::run(
                        model: $legacyPosition,
                        departments: $departmentsMap
                    );
                }
            }, 'pos_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Position::count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')
            ->table('positions')
            ->join('departments', 'positions.pos_dept', '=', 'departments.dept_id');
    }

    protected function getBatchJobs(): Collection
    {
        $this->truncateTable();

        return $this->query()
            ->get()
            ->map(fn ($position) => MigratePosition::makeJob($position));
    }

    protected function truncateTable(): void
    {
        Schema::disableForeignKeyConstraints();
        Position::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
