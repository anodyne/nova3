<?php

declare(strict_types=1);

namespace Nova\Stories\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Stories\Mail\SendPostSaved;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class PostSaved extends PreferenceBasedNotification
{
    protected string $key = 'post-saved';

    public function __construct(
        protected Post $post,
        protected User $user,
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_type_name' => $this->post->postType->name,
            'post_type_icon' => $this->post->postType->icon,
            'post_type_color' => $this->post->postType->color,
            'user_avatar' => $this->user->avatar_url,
            'user_name' => $this->user->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendPostSaved(
            post: $this->post,
            user: $this->user
        );
    }
}
