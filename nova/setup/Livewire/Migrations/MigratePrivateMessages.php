<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Nova\Discussions\Models\Discussion;
use Nova\Setup\Actions\Migration\MigratePrivateMessage;
use Nova\Setup\Models\Upgrade;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigratePrivateMessages extends MigrationStep
{
    public string $label = 'Private messages';

    public bool $shouldMigrate = false;

    public ?string $noteMessageLangKey = 'setup.migrate.private-messages-note';

    public function handleMigration(): void
    {
        set_time_limit(0);
        ini_set('max_execution_time', 300);

        $userMap = Upgrade::type('user')->get();

        $this->query()
            ->whereNotIn('privmsgs_id', Upgrade::type('private-message')->pluck('old_id'))
            ->chunkById(500, function (Collection $legacyPrivateMessages) use ($userMap) {
                foreach ($legacyPrivateMessages as $legacyPm) {
                    MigratePrivateMessage::run(
                        model: $legacyPm,
                        users: $userMap
                    );
                }
            }, 'privmsgs_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Discussion::query()->conversation()->count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')
            ->table('privmsgs')
            ->join('users', 'privmsgs.privmsgs_author_user', '=', 'users.userid');
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($pm) => MigratePrivateMessage::makeJob(model: $pm));
    }
}
