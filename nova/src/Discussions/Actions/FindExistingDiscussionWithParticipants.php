<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class FindExistingDiscussionWithParticipants extends Action
{
    public function handle(DiscussionData $data): ?Discussion
    {
        $ids = [$data->participants->sender, ...$data->participants->recipients];

        return Discussion::query()
            ->conversation()
            ->directMessage()
            ->whereJsonContains('direct_message_participants', $ids)
            ->first();
    }
}
