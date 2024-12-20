<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;

class UpdateContributorWordCount
{
    use AsAction;

    public function handle(Post $post, User $user, int $oldWordCount): Post
    {
        $postAuthorPivot = PostAuthor::query()
            ->wherePost($post)
            ->whereUser($user)
            ->first();

        $wordCountDiff = $post->word_count - $oldWordCount;

        if ($wordCountDiff > 0) {
            $postAuthorPivot->increment('word_count', $wordCountDiff);
        }

        return $post->refresh();
    }
}
