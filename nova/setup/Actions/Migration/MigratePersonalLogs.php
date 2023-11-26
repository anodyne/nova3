<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\Date;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Models\Legacy\PersonalLog as LegacyPersonalLog;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;

class MigratePersonalLogs
{
    use AsAction;

    public function handle(): void
    {
        $story = Story::create([
            'title' => 'Personal Logs',
            'description' => 'This is a temporary story for migrating personal logs from Nova 2. Game masters should move all personal logs into the appropriate story and remove this story when finished.',
            'status' => 'completed',
        ]);
        $story->moveBefore(Story::tree()->ordered()->first());

        $logPostTypeId = PostType::where('key', 'personal')->first()->id;

        LegacyPersonalLog::query()
            ->orderBy('log_date', 'asc')
            ->cursor()
            ->each(function (LegacyPersonalLog $log) use ($story, $logPostTypeId) {
                $post = Post::create([
                    'title' => $log->log_title,
                    'story_id' => $story->id,
                    'post_type_id' => $logPostTypeId,
                    'status' => match ($log->log_status) {
                        'saved' => Draft::class,
                        'pending' => Pending::class,
                        default => Published::class,
                    },
                    'content' => $log->log_content,
                    'word_count' => str($log->log_content)->pipe('strip_tags')->wordCount(),
                    'published_at' => $date = $log->log_date ? Date::createFromTimestamp($log->log_date) : null,
                    'created_at' => $date,
                    'updated_at' => $log->log_last_update ? Date::createFromTimestamp($log->log_last_update) : $date,
                ]);

                // TODO: need to set the user and character authors

                Upgrade::create([
                    'type' => 'personal-log',
                    'old_id' => $log->log_id,
                    'new_id' => $post->id,
                ]);
            });
    }
}
