<?php

declare(strict_types=1);

namespace Nova\Posts\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Characters\Models\Character;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Posts\Mail\SendCharacterAuthorAddedToPost;
use Nova\Posts\Models\Post;

class CharacterAuthorAddedToPost extends PreferenceBasedNotification
{
    protected string $key = 'character-author-added-to-post';

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
            'character_name' => $this->character->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendCharacterAuthorAddedToPost(
            post: $this->post,
            character: $this->character,
        );
    }
}
