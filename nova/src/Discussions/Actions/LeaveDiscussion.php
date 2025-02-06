<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Notifications\DiscussionParticipantExited;

class LeaveDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion): Discussion
    {
        $discussion = RemoveParticipantsFromDiscussion::run($discussion, [Auth::id()]);

        $discussion->refresh();

        $discussion->participants->each->notify(new DiscussionParticipantExited(
            discussion: $discussion,
            user: Auth::user()
        ));

        return $discussion;
    }
}
