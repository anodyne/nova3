<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Models\Discussion;

class SendSystemMessage
{
    use AsAction;

    public function handle(Discussion $discussion, DiscussionMessageData $data): void
    {
        $discussion->messages()->create($data->all());
    }
}
