<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;

class FindExistingDiscussionWithParticipants
{
    use AsAction;

    public function handle(DiscussionData $data): ?Discussion
    {
        if (! $data->isDirectMessage) {
            return null;
        }

        $ids = [$data->participants->sender, ...$data->participants->recipients];

        return Discussion::query()
            ->conversation()
            ->directMessage()
            ->whereJsonContains('direct_message_participants', $ids)
            ->first();
    }
}
