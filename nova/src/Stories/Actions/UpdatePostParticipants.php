<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class UpdatePostParticipants
{
    use AsAction;

    public function handle(Post $post, int $userId): Post
    {
        $participants = collect($post->participants)
            ->merge([$userId])
            ->filter()
            ->unique()
            ->values()
            ->map(fn ($value): int => (int) $value)
            ->toArray();

        $post->update(['participants' => $participants]);

        return $post->refresh();
    }
}
