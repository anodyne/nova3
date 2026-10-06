<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Bag\Bag;
use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class UpdatePost extends Action
{
    public function handle(Post $post, Bag $data, ?User $user = null): Post
    {
        $post->fill($data->toArray());

        UpdateContributorData::run($post, $user);

        $post->save();

        return $post;
    }
}
