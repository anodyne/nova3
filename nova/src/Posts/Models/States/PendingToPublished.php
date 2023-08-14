<?php

declare(strict_types=1);

namespace Nova\Posts\Models\States;

use Nova\Posts\Models\Post;
use Spatie\ModelStates\Transition;

class PendingToPublished extends Transition
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
            ->log(':subject.title post was published from a pending state');

        return $this->post->refresh();
    }
}
