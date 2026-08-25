<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

class MigratePost
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    /**
     * @param  Collection<int, object>|null  $missions
     * @param  Collection<int, object>|null  $users
     */
    public function handle(object $model, int $postPostTypeId, ?Collection $missions, ?Collection $users): void
    {
        $newStoryId = $this->getNewId(
            id: $model->post_mission,
            collection: $missions,
            upgradeKey: 'mission'
        );

        $lastSavedUserId = $this->getNewId(
            id: $model->post_saved,
            collection: $users,
            upgradeKey: 'user'
        );

        DB::transaction(function () use ($model, $postPostTypeId, $newStoryId, $lastSavedUserId): void {
            $postId = DB::table('posts')->insertGetId([
                'title' => $model->post_title,
                'location' => $model->post_location,
                'time' => $model->post_timeline,
                'post_type_id' => $postPostTypeId,
                'story_id' => $newStoryId,
                'status' => match ($model->post_status) {
                    'saved' => 'draft',
                    'pending' => 'pending',
                    default => 'published',
                },
                'content' => $model->post_content,
                'word_count' => str($model->post_content)->pipe('strip_tags')->wordCount(),
                'published_at' => $date = $model->post_status === 'activated' ? $this->convertDate($model->post_date) : null,
                'last_update_by' => $lastSavedUserId,
                'created_at' => $created = $date ?? now('UTC'),
                'updated_at' => $this->convertDate($model->post_last_update, $created),
            ]);

            $characterIds = Upgrade::query()
                ->type('character')
                ->whereIn('old_id', explode(',', $model->post_authors ?? ''))
                ->pluck('new_id');

            Character::with('activeUsers')
                ->whereIn('id', $characterIds)
                ->get()
                ->each(function (Character $character) use ($postId, $created): void {
                    DB::table('post_author')->insert([
                        'post_id' => $postId,
                        'authorable_type' => 'character',
                        'authorable_id' => $character->id,
                        'user_id' => $character->activeUsers->first()?->id,
                        'created_at' => $created,
                        'updated_at' => $created,
                    ]);
                });

            Upgrade::firstOrCreate([
                'type' => 'post',
                'old_id' => $model->post_id,
                'new_id' => $postId,
            ]);
        });
    }

    public function asJob(object $model, int $postPostTypeId): void
    {
        $this->handle(
            model: $model,
            postPostTypeId: $postPostTypeId,
            missions: null,
            users: null
        );
    }
}
