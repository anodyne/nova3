<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;

class UpdateContributorWordCount extends Action
{
    public function handle(Post $post, User $user, int $wordCountDiff): void
    {
        if ($wordCountDiff <= 0) {
            return;
        }

        $postAuthorPivot = PostAuthor::query()
            ->wherePost($post)
            ->whereUser($user)
            ->orderBy('id')
            ->firstOrFail();

        $postAuthorPivot->increment('word_count', $wordCountDiff);
    }
}
