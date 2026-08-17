<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Discussions\Models\Discussion;

class DiscussionSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $now = Date::now()->setMicrosecond(0)->toDateTimeString();

        $seedChat = function (array $discussionAttrs, array $participantIds, array $authorPool, int $count = 5) use ($now) {
            /** @var Discussion $discussion */
            $discussion = Discussion::factory()->create(
                ['created_at' => $now, 'updated_at' => $now] + $discussionAttrs
            );
            $discussion->allParticipants()->sync($participantIds);

            if ($count > 0) {
                $rows = [];
                for ($i = 0; $i < $count; $i++) {
                    $rows[] = [
                        'discussion_id' => $discussion->id,
                        'user_id' => $authorPool[array_rand($authorPool)],
                        'type' => 'text',
                        'content' => fake()->paragraph(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                DB::table('discussion_messages')->insert($rows);
            }
        };

        $seedChat(['subject' => 'Group message'], [1, 2, 3], [1, 2, 3], 5);

        $seedChat([], [1, 2], [1, 2], 5);

        activity()->enableLogging();
    }
}
