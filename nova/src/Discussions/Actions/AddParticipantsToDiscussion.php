<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionParticipantsData;
use Nova\Discussions\Models\Discussion;

class AddParticipantsToDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion, DiscussionParticipantsData $data): Discussion
    {
        $discussion->participants()->attach(array_merge([$data->sender], $data->recipients));

        return $discussion->refresh();
    }
}
