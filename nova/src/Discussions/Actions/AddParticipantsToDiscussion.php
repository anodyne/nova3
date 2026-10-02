<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class AddParticipantsToDiscussion extends Action
{
    public function handle(Discussion $discussion, DiscussionParticipantsData $data): Discussion
    {
        $discussion->participants()->attach([
            ...[$data->sender],
            ...$data->recipients,
        ]);

        return $discussion->refresh();
    }
}
