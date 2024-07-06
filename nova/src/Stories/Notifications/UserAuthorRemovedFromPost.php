<?php

declare(strict_types=1);

namespace Nova\Stories\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Stories\Mail\SendUserAuthorRemovedFromPost;
use Nova\Stories\Models\Post;

class UserAuthorRemovedFromPost extends PreferenceBasedNotification
{
    protected string $key = 'user-author-removed-from-post';

    public function __construct(
        protected Post $post
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_type_name' => $this->post->postType->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendUserAuthorRemovedFromPost(
            post: $this->post
        );
    }
}
