<?php

declare(strict_types=1);

namespace Nova\Stories\Listeners;

use Nova\Stories\Events\PostCreating;

class SetDefaultContentRatings
{
    public function handle(PostCreating $event): void
    {
        $post = $event->post;

        $post->rating_language = settings('ratings.language.rating');
        $post->rating_sex = settings('ratings.sex.rating');
        $post->rating_violence = settings('ratings.violence.rating');
    }
}
