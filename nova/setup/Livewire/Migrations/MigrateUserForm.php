<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Nova\Forms\Models\FormField;
use Nova\Setup\Actions\Migration\MigrateLegacyUserData;
use Nova\Setup\Livewire\Concerns\HandlesFormFields;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateUserForm extends MigrationStep
{
    use HandlesFormFields;
    use HandlesNewIds;

    public string $label = 'User form';

    public ?string $noteMessageLangKey = 'setup.migrate.users-form';

    public function handleMigration(): void
    {
        MigrateLegacyUserData::run();
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return 5;
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return FormField::query()
            ->whereRelation('form', 'forms.key', '=', 'userBio')
            ->count();
    }

    protected function getBatchJobs(): Collection
    {
        return collect([
            MigrateLegacyUserData::makeJob(),
        ]);
    }
}
