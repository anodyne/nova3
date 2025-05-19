<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Nova\Setup\Actions\Migration\UpdatePostOrder;

class UpdatePostOrdering extends MigrationStep
{
    public string $label = 'Update post ordering';

    public bool $canDisableMigration = false;

    public bool $shouldMigrate = true;

    public ?string $noteMessageLangKey = 'setup.migrate.post-ordering-note';

    public function handleMigration(): void
    {
        set_time_limit(0);
        ini_set('max_execution_time', 300);

        UpdatePostOrder::run();
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return DB::table('posts')->whereNull('order_column')->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return DB::table('posts')->whereNotNull('order_column')->count();
    }

    protected function getBatchJobs(): Collection
    {
        return collect([
            UpdatePostOrder::makeJob(),
        ]);
    }
}
