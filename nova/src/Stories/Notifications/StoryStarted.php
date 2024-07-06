<?php

declare(strict_types=1);

namespace Nova\Stories\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Stories\Mail\SendStoryStarted;
use Nova\Stories\Models\Story;

class StoryStarted extends PreferenceBasedNotification
{
    protected string $key = 'story-started';

    public function __construct(
        protected Story $story
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'story_id' => $this->story->id,
            'story_title' => $this->story->title,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendStoryStarted(
            story: $this->story
        );
    }
}
