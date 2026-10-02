<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Notifications\DiscussionParticipantExited;
use Nova\Foundation\Actions\Action;

class LeaveDiscussion extends Action
{
    public function handle(Discussion $discussion): Discussion
    {
        $user = Auth::user();

        if ($user === null) {
            throw new AuthenticationException;
        }

        $discussion = RemoveParticipantsFromDiscussion::run(
            $discussion,
            [$user->id]
        );

        $discussion->participants->each->notify(new DiscussionParticipantExited(
            discussion: $discussion,
            user: $user
        ));

        return $discussion;
    }
}
