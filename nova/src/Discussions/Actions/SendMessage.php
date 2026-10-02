<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class SendMessage extends Action
{
    public function handle(Discussion $discussion, DiscussionData $data): void
    {
        $discussionMessage = $discussion->messages()->create($data->message->toArray());

        // Broadcast

        NotifyParticipants::run(
            discussion: $discussion,
            message: $discussionMessage,
            data: $data->participants
        );
    }
}
