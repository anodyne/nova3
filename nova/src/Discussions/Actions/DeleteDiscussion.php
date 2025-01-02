<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;

class DeleteDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion): void
    {
        DiscussionMessage::where('discussion_id', $discussion->id)->delete();

        $discussion->delete();
    }
}
