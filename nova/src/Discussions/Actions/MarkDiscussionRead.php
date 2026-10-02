<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class MarkDiscussionRead extends Action
{
    public function handle(Discussion $discussion, User $user): void
    {
        DiscussionNotification::query()
            ->discussion($discussion->id)
            ->user($user->id)
            ->update(['is_seen' => true]);
    }
}
