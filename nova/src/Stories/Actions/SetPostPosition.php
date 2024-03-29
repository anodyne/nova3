<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Models\Post;

class SetPostPosition
{
    use AsAction;

    public function handle(Post $post, PostPositionData $data): Post
    {
        if ($data->hasPositionChange) {
            if ($data->direction && $data->neighbor) {
                $method = 'move'.ucfirst($data->direction);

                $post->$method($data->neighbor);
            }
        }

        return $post->refresh();
    }
}
