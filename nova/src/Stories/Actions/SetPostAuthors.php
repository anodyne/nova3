<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Models\Post;

class SetPostAuthors
{
    use AsAction;

    public function handle(Post $post, PostAuthorsData $data): Post
    {
        $post->characterAuthors()->sync($data->characters->map(fn ($character) => $character->id));
        $post->userAuthors()->sync($data->users->map(fn ($user) => $user->id));

        return $post->refresh();
    }
}
