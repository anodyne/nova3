<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Posts\Models\Post;

class CharacterAuthorAddedToPost extends PreferenceBasedNotification
{
    protected string $key = 'character-author-added-to-post';

    public function __construct(
        protected Post $post,
        protected array $characterNames
    ) {
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_type_name' => $this->post->postType->name,
            'character_count' => count($this->characterNames),
            'character_names' => collect($this->characterNames)->join(', ', ' and '),
        ];
    }
}
