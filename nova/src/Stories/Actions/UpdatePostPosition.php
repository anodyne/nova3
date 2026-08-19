<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Models\Post;

class UpdatePostPosition
{
    use AsAction;

    public function handle(Post $post, PostPositionData $data): Post
    {
        if ($data->hasPositionChange) {
            $method = $data->moveMethodName();

            if ($data->neighbor) {
                $post->$method($data->neighbor);
            } else {
                $post->$method();
            }
        }

        return $post->refresh();
    }
}
