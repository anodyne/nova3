<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;

class SendMessage
{
    use AsAction;

    public function handle(Discussion $discussion, DiscussionData $data): void
    {
        $model = $discussion->messages()->create($data->message->toArray());

        // Broadcast

        NotifyParticipants::run(
            discussion: $discussion,
            message: $model,
            data: $data->participants
        );
    }
}
