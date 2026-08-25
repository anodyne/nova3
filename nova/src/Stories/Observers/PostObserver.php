<?php

declare(strict_types=1);

namespace Nova\Stories\Observers;

use Illuminate\Support\Facades\Auth;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class PostObserver
{
    public function saving(Post $post): void
    {
        if ($post->isDirty('content')) {
            $post->word_count = str($post->content)->pipe('strip_tags')->wordCount();
            $user = Auth::user();
            $post->last_update_by = $user instanceof User ? $user->id : null;
            $post->participants = $user instanceof User ? $this->getNewParticipants($post, $user->id) : null;
        }
    }

    /** @return list<int> */
    private function getNewParticipants(Post $post, int $userId): array
    {
        return array_values(collect($post->participants)
            ->merge([$userId])
            ->filter()
            ->unique()
            ->values()
            ->map(fn ($value): int => (int) $value)
            ->all());
    }
}
