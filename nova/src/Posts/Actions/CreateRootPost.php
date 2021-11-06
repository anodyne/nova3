<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Published;
use Nova\Stories\Models\Story;

class CreateRootPost
{
    use AsAction;

    public function handle(Story $story): Post
    {
        return $story->posts()->create([
            'title' => "{$story->title} Root Post",
            'status' => Published::class,
        ]);
    }
}
