<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Nova\Characters\Models\Character;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Posts\Models\Post;

class CharacterAuthorRemovedFromPost extends PreferenceBasedNotification
{
    protected string $key = 'character-author-removed-from-post';

    public function __construct(
        protected Post $post,
        protected Character $character
    ) {
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_type_name' => $this->post->postType->name,
            'character_name' => $this->character->displayName,
        ];
    }
}
