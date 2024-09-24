<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Discussions\Notifications\DiscussionMessageReceived;
use Nova\Users\Models\User;

class NotifyParticipants
{
    use AsAction;

    public function handle(Discussion $discussion, DiscussionMessage $message, DiscussionParticipantsData $data): void
    {
        $discussion->allParticipants->each(function (User $user) use ($data, $message) {
            DiscussionNotification::create([
                'discussion_id' => $message->discussion_id,
                'discussion_message_id' => $message->id,
                'user_id' => $user->id,
                'is_sender' => $data->sender === $user->id,
                'is_seen' => $data->sender === $user->id,
            ]);
        });

        $discussion->participants->each->notify(new DiscussionMessageReceived(
            discussion: $discussion,
            message: $message
        ));
    }
}
