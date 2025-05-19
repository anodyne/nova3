<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Story;

class MigratePersonalLog
{
    use AsAction;
    use HandlesDates;

    public function handle(object $model, Story $story, int $logPostTypeId): void
    {
        DB::transaction(function () use ($model, $story, $logPostTypeId) {
            $logId = DB::table('posts')->insertGetId([
                'title' => $model->log_title,
                'post_type_id' => $logPostTypeId,
                'story_id' => $story->id,
                'status' => match ($model->log_status) {
                    'saved' => 'draft',
                    'pending' => 'pending',
                    default => 'published',
                },
                'content' => $model->log_content,
                'word_count' => str($model->log_content)->pipe('strip_tags')->wordCount(),
                'published_at' => $date = $model->log_status === 'activated' ? $this->convertDate($model->log_date) : null,
                'created_at' => $created = $date ?? now('UTC'),
                'updated_at' => $this->convertDate($model->log_last_update, $created),
            ]);

            Character::with('activeUsers')
                ->where('id', Upgrade::type('character')->where('old_id', $model->log_author_character)->first()?->new_id)
                ->get()
                ->each(function (Character $character) use ($logId, $created) {
                    DB::table('post_author')->insert([
                        'post_id' => $logId,
                        'authorable_type' => 'character',
                        'authorable_id' => $character->id,
                        'user_id' => $character->activeUsers->first()?->id,
                        'created_at' => $created,
                        'updated_at' => $created,
                    ]);
                });

            Upgrade::firstOrCreate([
                'type' => 'personal-log',
                'old_id' => $model->log_id,
                'new_id' => $logId,
            ]);
        });
    }

    public function asJob(object $model, Story $story, int $logPostTypeId): void
    {
        $this->handle(
            model: $model,
            story: $story,
            logPostTypeId: $logPostTypeId
        );
    }
}
