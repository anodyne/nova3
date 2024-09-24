<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Models\Discussion;

class RemoveParticipantsFromDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion, array $participants): Discussion
    {
        $discussion->notifications()->whereIn('user_id', $participants)->delete();

        $discussion->allParticipants()->detach($participants);

        return $discussion->refresh();
    }
}
