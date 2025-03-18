<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Computed;
use Nova\Departments\Models\Department;
use Nova\Setup\Actions\Migration\MigrateDepartment;
use Nova\Setup\Models\Upgrade;

class MigrateDepartments extends MigrationStep
{
    public string $label = 'Departments';

    public function handleMigration(): void
    {
        $this->truncateTable();

        $this->query()
            ->whereNotIn('dept_id', Upgrade::type('department')->pluck('old_id'))
            ->chunkById(100, function (Collection $legacyDepartments) {
                foreach ($legacyDepartments as $legacyDepartment) {
                    MigrateDepartment::run($legacyDepartment);
                }
            }, 'dept_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Department::count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('departments');
    }

    protected function getBatchJobs(): Collection
    {
        $this->truncateTable();

        return $this->query()
            ->get()
            ->map(fn ($department) => MigrateDepartment::makeJob($department));
    }

    protected function truncateTable(): void
    {
        Schema::disableForeignKeyConstraints();
        Department::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
