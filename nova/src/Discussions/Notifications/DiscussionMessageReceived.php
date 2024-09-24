<?php

declare(strict_types=1);

namespace Nova\Discussions\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Discussions\Mail\SendDiscussionMessageReceived;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Foundation\Notifications\PreferenceBasedNotification;

class DiscussionMessageReceived extends PreferenceBasedNotification
{
    protected string $key = 'discussion-message-received';

    public function __construct(
        protected Discussion $discussion,
        protected DiscussionMessage $message
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'discussion_id' => $this->discussion->id,
            'discussion_name' => $this->discussion->name,
            'is_direct_message' => $this->discussion->is_direct_message,
            'message' => $this->message->content,
            'sender' => $this->message->user->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendDiscussionMessageReceived(
            discussion: $this->discussion,
            message: $this->message
        );
    }
}
