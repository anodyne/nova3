<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class SendSystemMessage extends Action
{
    public function handle(Discussion $discussion, DiscussionMessageData $data): void
    {
        $discussion->messages()->create($data->toArray());
    }
}
