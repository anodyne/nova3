<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Stories\Data\PostDetailsData;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class SavePostDetails extends Action
{
    public function handle(string $postId, PostDetailsData $data, User $user): Post
    {
        return DB::transaction(function () use ($postId, $data, $user): Post {
            $post = Post::query()
                ->setEagerLoads([])
                ->lockForUpdate()
                ->findOrFail($postId);

            $oldWordCount = $post->word_count;

            UpdatePost::run($post, $data, $user);

            UpdateContributorWordCount::run($post, $user, $post->word_count - $oldWordCount);

            return $post;
        });
    }
}
