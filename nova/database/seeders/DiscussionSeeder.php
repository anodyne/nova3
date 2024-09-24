<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupChat = Discussion::factory()
            ->groupMessage()
            ->create(['name' => 'Group message']);

        $groupChat->allParticipants()->sync([1, 2, 3]);

        $groupChat->refresh();

        for ($i = 0; $i < 5; $i++) {
            DiscussionMessage::factory()
                ->text()
                ->create([
                    'discussion_id' => $groupChat->id,
                    'user_id' => fake()->randomElement([1, 2, 3]),
                ]);
        }

        $privateChat = Discussion::factory()
            ->directMessage()
            ->create(['direct_message_participants' => [1, 2]]);

        $privateChat->allParticipants()->sync([1, 2]);

        $privateChat->refresh();

        for ($i = 0; $i < 5; $i++) {
            DiscussionMessage::factory()
                ->text()
                ->create([
                    'discussion_id' => $privateChat->id,
                    'user_id' => fake()->randomElement([1, 2]),
                ]);
        }

    }
}
