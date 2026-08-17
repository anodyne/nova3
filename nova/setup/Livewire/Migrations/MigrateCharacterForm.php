<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Nova\Forms\Models\FormField;
use Nova\Setup\Actions\Migration\MigrateForm;
use Nova\Setup\Livewire\Concerns\HandlesFormFields;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateCharacterForm extends MigrationStep
{
    use HandlesFormFields;
    use HandlesNewIds;

    public string $label = 'Character form';

    public function handleMigration(): void
    {
        MigrateForm::run();
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return FormField::query()
            ->whereRelation('form', 'forms.key', '=', 'characterBio')
            ->count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('characters_fields');
    }

    protected function getBatchJobs(): Collection
    {
        return collect([
            MigrateForm::makeJob(),
        ]);
    }
}
