<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Actions\DeletePost;
use Nova\Stories\Models\Story;

class DeleteStoryPosts
{
    use AsAction;

    public function handle(Story $story): Story
    {
        $story->posts->each(fn ($post) => DeletePost::run($post));

        return $story->refresh();
    }
}
