<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Applications\Models\Application;
use Nova\Setup\Actions\Migration\MigrateApplication;
use Nova\Setup\Models\Upgrade;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateApplications extends MigrationStep
{
    public string $label = 'Applications';

    public function handleMigration(): void
    {
        $characterMap = Upgrade::type('character')->get();
        $userMap = Upgrade::type('user')->get();

        $this->query()
            ->whereNotIn('app_id', Upgrade::type('application')->pluck('old_id'))
            ->chunkById(100, function (Collection $legacyApplications) use ($characterMap, $userMap): void {
                foreach ($legacyApplications as $legacyApplication) {
                    MigrateApplication::run(
                        model: $legacyApplication,
                        characters: $characterMap,
                        users: $userMap
                    );
                }
            }, 'app_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Application::count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')
            ->table('applications')
            ->join('users', 'applications.app_user', '=', 'users.userid')
            ->join('characters', 'applications.app_character', '=', 'characters.charid')
            ->whereIn('applications.app_action', ['accepted', 'rejected', 'pending']);
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($application): JobDecorator => MigrateApplication::makeJob($application));
    }
}
