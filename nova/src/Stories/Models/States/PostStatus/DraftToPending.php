<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

use Nova\Stories\Models\Post;
use Spatie\ModelStates\Transition;

class DraftToPending extends Transition
{
    public function __construct(
        protected Post $post
    ) {}

    public function handle(): Post
    {
        $this->post->status = Pending::class;
        $this->post->save();

        activity()
            ->performedOn($this->post)
            ->event('pending')
            ->log(':subject.title post was moved to a pending state');

        return $this->post->refresh();
    }
}
