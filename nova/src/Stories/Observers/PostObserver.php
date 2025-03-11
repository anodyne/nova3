<?php

declare(strict_types=1);

namespace Nova\Stories\Observers;

use Illuminate\Support\Facades\Auth;
use Nova\Stories\Models\Post;

class PostObserver
{
    public function saving(Post $post): void
    {
        $post->word_count = str($post->content)->pipe('strip_tags')->wordCount();

        if ($post->isDirty('content')) {
            $post->last_update_by = $id = Auth::id();
            $post->participants = filled($id) ? $this->getNewParticipants($post, Auth::id()) : null;
        }
    }

    private function getNewParticipants(Post $post, int $userId): array
    {
        return collect($post->participants)
            ->merge([$userId])
            ->filter()
            ->unique()
            ->values()
            ->map(fn ($value): int => (int) $value)
            ->toArray();
    }
}
