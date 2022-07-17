<?php

declare(strict_types=1);

namespace Nova\Posts\Models\States;

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

        User::whereActive()->get()->each->notify(new PostPublished($this->post));

        return $this->post->refresh();
    }
}
