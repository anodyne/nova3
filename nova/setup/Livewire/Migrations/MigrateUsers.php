<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Setup\Actions\Migration\MigrateUser;
use Nova\Setup\Models\Upgrade;
use Nova\Users\Models\User;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateUsers extends MigrationStep
{
    public string $label = 'Users';

    public bool $canDisableMigration = false;

    public bool $shouldMigrate = true;

    public ?string $noteMessageLangKey = 'setup.migrate.users-cannot-be-disabled';

    public function handleMigration(): void
    {
        $this->query()
            ->whereNotIn('userid', Upgrade::type('user')->pluck('old_id'))
            ->chunkById(100, function (Collection $users): void {
                foreach ($users as $user) {
                    MigrateUser::run(model: $user);
                }
            }, 'userid');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return User::count();
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($user): JobDecorator => MigrateUser::makeJob($user));
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('users');
    }
}
