<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Setup\Actions\Migration\MigratePost;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigratePosts extends MigrationStep
{
    public string $label = 'Mission posts';

    public function handleMigration(): void
    {
        set_time_limit(0);
        ini_set('max_execution_time', 300);

        $missionMap = Upgrade::type('mission')->get();
        $userMap = Upgrade::type('user')->get();

        $postPostTypeId = PostType::where('key', 'post')->first()->id;

        $this->query()
            ->whereNotIn('post_id', Upgrade::type('post')->pluck('old_id'))
            ->chunkById(500, function (Collection $legacyPosts) use ($missionMap, $userMap, $postPostTypeId): void {
                foreach ($legacyPosts as $legacyPost) {
                    MigratePost::run(
                        model: $legacyPost,
                        postPostTypeId: $postPostTypeId,
                        missions: $missionMap,
                        users: $userMap
                    );
                }
            }, 'post_id');
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
            ->where('post_type_id', '!=', PostType::where('key', 'personal')->first()->id)
            ->count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')
            ->table('posts')
            ->join('missions', 'posts.post_mission', '=', 'missions.mission_id');
    }

    protected function getBatchJobs(): Collection
    {
        $postPostTypeId = PostType::where('key', 'post')->first()->id;

        return $this->query()
            ->get()
            ->map(fn ($post): JobDecorator => MigratePost::makeJob(model: $post, postPostTypeId: $postPostTypeId));
    }
}
