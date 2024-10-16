<?php

declare(strict_types=1);

namespace Nova\Stories\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Stories\Mail\SendUserAuthorAddedToPost;
use Nova\Stories\Models\Post;

class UserAuthorAddedToPost extends PreferenceBasedNotification
{
    protected string $key = 'user-author-added-to-post';

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
        return new SendUserAuthorAddedToPost(
            post: $this->post
        );
    }
}
