<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Posts\Models\Post;

class PostPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Post $post
    ) {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
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
