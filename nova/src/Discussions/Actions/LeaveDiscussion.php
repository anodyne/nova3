<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionMessageData;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;

class LeaveDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion): Discussion
    {
        $discussion = RemoveParticipantsFromDiscussion::run($discussion, [Auth::id()]);

        SendSystemMessage::runUnless($discussion->is_direct_message, $discussion, new DiscussionMessageData(
            userId: null,
            content: Auth::user()->name.' left the conversation',
            type: MessageType::SystemDanger,
        ));

        return $discussion->refresh();
    }
}
