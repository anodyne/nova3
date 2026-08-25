<?php

declare(strict_types=1);

use Database\Seeders\ApplicationSeeder;
use Nova\Discussions\Models\Discussion;
use Nova\Users\Models\User;

it('creates discussion messages from the available user ID list', function () {
    $users = User::factory()->count(3)->create();
    $discussion = Discussion::factory()->create();
    $seeder = new class extends ApplicationSeeder
    {
        /** @param list<int> $authorIds */
        public function createMessages(int $discussionId, int $count, array $authorIds): void
        {
            $this->bulkCreateDiscussionMessages($discussionId, $count, $authorIds);
        }
    };

    $seeder->createMessages($discussion->id, 5, []);

    $messages = $discussion->messages()->get();
    $userIds = $users->modelKeys();

    expect($messages)->toHaveCount(5);

    $messages->each(function ($message) use ($userIds): void {
        expect($message->user_id)->toBeIn($userIds);
    });
});
