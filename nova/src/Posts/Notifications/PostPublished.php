<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Posts\Mail\SendPostPublished;
use Nova\Posts\Models\Post;

class PostPublished extends PreferenceBasedNotification
{
    protected string $key = 'post-published';

    public function __construct(
        protected Post $post
    ) {
    }

    public function via(object $notifiable): array
    {
        if (! $this->post->postType->options->notifiesUsers) {
            return [];
        }

        return parent::via($notifiable);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'story_id' => $this->post->story_id,
            'story_title' => $this->post->story->title,
            'post_type_name' => $this->post->postType->name,
            'post_type_icon' => $this->post->postType->icon,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendPostPublished(
            post: $this->post
        );
    }
}
