<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Posts\Models\Post;

class UserAuthorRemovedFromPost extends Notification implements ShouldQueue
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
            'post_type_name' => $this->post->postType->name,
        ];
    }
}
