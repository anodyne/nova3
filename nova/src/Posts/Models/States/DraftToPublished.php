<?php

declare(strict_types=1);

namespace Nova\Posts\Models\States;

use Nova\Posts\Actions\PruneAbandonedPosts;
use Nova\Posts\Models\Post;
use Nova\Posts\Notifications\PostPublished;
use Nova\Users\Models\User;
use Spatie\ModelStates\Transition;

class DraftToPublished extends Transition
{
    public function __construct(
        protected Post $post
    ) {
    }

    public function handle(): Post
    {
        $this->post->status = Published::class;
        $this->post->published_at = now();
        $this->post->save();

        activity()
            ->performedOn($this->post)
            ->event('published')
            ->log(':subject.title post was published from a draft state');

        User::active()->get()->each->notify(new PostPublished($this->post));

        PruneAbandonedPosts::run();

        return $this->post->refresh();
    }
}
