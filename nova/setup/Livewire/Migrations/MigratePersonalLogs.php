<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Setup\Actions\Migration\MigratePersonalLog;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigratePersonalLogs extends MigrationStep
{
    public string $label = 'Personal logs';

    public function handleMigration(): void
    {
        $logPostTypeId = PostType::where('key', 'personal')->first()->id;

        $this->query()
            ->whereNotIn('log_id', Upgrade::type('personal-log')->pluck('old_id'))
            ->chunkById(100, function (Collection $legacyLogs) use ($logPostTypeId): void {
                foreach ($legacyLogs as $legacyLog) {
                    MigratePersonalLog::run(
                        model: $legacyLog,
                        story: $this->getPersonalLogTempStory(),
                        logPostTypeId: $logPostTypeId
                    );
                }
            }, 'log_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Post::query()
            ->where('post_type_id', PostType::where('key', 'personal')->first()->id)
            ->count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')->table('personallogs');
    }

    protected function getBatchJobs(): Collection
    {
        $logPostTypeId = PostType::where('key', 'personal')->first()->id;

        return $this->query()
            ->get()
            ->map(fn ($log): JobDecorator => MigratePersonalLog::makeJob(
                model: $log,
                story: $this->getPersonalLogTempStory(),
                logPostTypeId: $logPostTypeId
            ));
    }

    protected function getPersonalLogTempStory(): Story
    {
        $story = Story::firstOrCreate(['title' => 'Personal log migration'], [
            'description' => 'This is a temporary story for migrating personal logs from Nova 2. Game masters should move all personal logs into the appropriate story and remove this story when finished.',
            'status' => 'completed',
        ]);
        $story->moveToStart();

        return $story;
    }
}
