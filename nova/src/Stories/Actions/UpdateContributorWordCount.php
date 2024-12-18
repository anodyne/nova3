<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\Cache;
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
            ->wherePost($post->id)
            ->whereUser($user->id)
            ->first();

        $wordCountDiff = $post->word_count - $oldWordCount;

        if ($wordCountDiff > 0) {
            $postAuthorPivot->increment('word_count', $wordCountDiff);

            Cache::forget("stats-posting-user-{$user->id}-posts-all");
            Cache::forget("stats-posting-user-{$user->id}-words-all");
        }

        return $post->refresh();
    }
}
