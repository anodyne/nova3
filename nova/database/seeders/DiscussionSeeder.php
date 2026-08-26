<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Discussions\Models\Discussion;
use Nova\Users\Models\User;

class DiscussionSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $now = Date::now()->setMicrosecond(0)->toDateTimeString();

        $userIds = array_values(
            User::query()
                ->orderBy('id')
                ->limit(3)
                ->get(['id'])
                ->map(fn (User $user): string => $user->id)
                ->all()
        );

        $seedChat = function (array $discussionAttributes, array $participantIds, array $authorPool, int $count = 5) use ($now): void {
            /** @var Discussion $discussion */
            $discussion = Discussion::factory()->create(
                ['created_at' => $now, 'updated_at' => $now] + $discussionAttributes
            );
            $discussion->allParticipants()->sync($participantIds);

            if ($count > 0) {
                $rows = [];
                for ($i = 0; $i < $count; $i++) {
                    $rows[] = [
                        'id' => str()->uuid7()->toString(),
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

        $seedChat(['subject' => 'Group message'], $userIds, $userIds, 5);

        $directMessageUserIds = array_slice($userIds, 0, 2);

        $seedChat([], $directMessageUserIds, $directMessageUserIds, 5);

        activity()->enableLogging();
    }
}
