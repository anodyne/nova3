<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Models\Post;

class UpdatePostAuthors
{
    use AsAction;

    public function handle(Post $post, PostAuthorsData $data): Post
    {
        $post->characterAuthors()->sync($data->characters);

        $post->userAuthors()->sync($data->users);

        return $post->refresh();
    }
}
