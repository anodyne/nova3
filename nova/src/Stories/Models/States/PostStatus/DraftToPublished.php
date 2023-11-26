<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

use Nova\Stories\Actions\PruneAbandonedPosts;
use Nova\Stories\Events\PostPublished as PostPublishedEvent;
use Nova\Stories\Models\Post;
use Nova\Stories\Notifications\PostPublished;
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

        PostPublishedEvent::dispatch($this->post);

        PruneAbandonedPosts::run();

        return $this->post->refresh();
    }
}
