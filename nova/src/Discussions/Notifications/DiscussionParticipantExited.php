<?php

declare(strict_types=1);

namespace Nova\Discussions\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Discussions\Mail\SendDiscussionParticipantExitedMail;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Users\Models\User;

class DiscussionParticipantExited extends PreferenceBasedNotification
{
    protected string $key = 'discussion-participant-exited';

    public function __construct(
        protected Discussion $discussion,
        protected User $user
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'discussion_id' => $this->discussion->id,
            'discussion_subject' => $this->discussion->subject,
            'user_name' => $this->user?->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendDiscussionParticipantExitedMail(
            discussion: $this->discussion,
            user: $this->user
        );
    }
}
