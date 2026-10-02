<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;

class UpdatePostParticipants extends Action
{
    public function handle(Post $post, string $userId): Post
    {
        $participants = collect($post->participants)
            ->merge([$userId])
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $post->update(['participants' => $participants]);

        return $post->refresh();
    }
}
