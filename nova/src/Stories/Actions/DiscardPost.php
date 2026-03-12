<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;
use Nova\Stories\Notifications\DraftPostDiscarded;
use Nova\Users\Models\User;

class DiscardPost
{
    use AsAction;

    public function handle(Post $post, ?User $discardedBy = null): Post
    {
        $discardedBy ??= Auth::user();

        if ($discardedBy !== null) {
            $post->participatingUsers->each->notify(new DraftPostDiscarded($post, $discardedBy));
        }

        $post->characterAuthors()->detach();

        $post->userAuthors()->detach();

        return tap($post)->forceDelete();
    }
}
