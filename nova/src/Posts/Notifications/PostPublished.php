<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Posts\Models\Post;

class PostPublished extends PreferenceBasedNotification
{
    protected string $key = 'post-published';

    public function __construct(
        protected Post $post
    ) {
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
}
