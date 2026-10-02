<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class RemoveParticipantsFromDiscussion extends Action
{
    /** @param list<int|string> $participants */
    public function handle(Discussion $discussion, array $participants): Discussion
    {
        $discussion->notifications()->whereIn('user_id', $participants)->delete();

        $discussion->allParticipants()->detach($participants);

        return $discussion->refresh();
    }
}
