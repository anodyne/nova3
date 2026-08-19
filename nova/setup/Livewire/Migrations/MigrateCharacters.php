<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Characters\Models\Character;
use Nova\Setup\Actions\Migration\MigrateCharacter;
use Nova\Setup\Models\Upgrade;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateCharacters extends MigrationStep
{
    public string $label = 'Characters';

    public bool $canDisableMigration = false;

    public bool $shouldMigrate = true;

    public ?string $noteMessageLangKey = 'setup.migrate.characters-cannot-be-disabled';

    public function handleMigration(): void
    {
        $userMap = Upgrade::type('user')->get();
        $positionMap = Upgrade::type('position')->get();

        $this->query()
            ->whereNotIn('charid', Upgrade::type('character')->pluck('old_id'))
            ->chunkById(100, function (Collection $legacyCharacters) use ($userMap, $positionMap): void {
                foreach ($legacyCharacters as $legacyCharacter) {
                    MigrateCharacter::run(
                        model: $legacyCharacter,
                        users: $userMap,
                        positions: $positionMap
                    );
                }
            }, 'charid');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Character::count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('characters');
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($character): JobDecorator => MigrateCharacter::makeJob($character));
    }
}
