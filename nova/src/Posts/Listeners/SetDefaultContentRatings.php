<?php

declare(strict_types=1);

namespace Nova\Posts\Listeners;

use Nova\Posts\Events\PostCreating;

class SetDefaultContentRatings
{
    public function handle(PostCreating $event): void
    {
        $post = $event->post;

        $post->rating_language = settings()->ratings->language->rating;
        $post->rating_sex = settings()->ratings->sex->rating;
        $post->rating_violence = settings()->ratings->violence->rating;
    }
}
