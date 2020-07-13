<?php

namespace Nova\Stories\Models\States\Posts;

use Nova\Stories\Models\Post;
use Spatie\ModelStates\Transition;

class PendingToPublished extends Transition
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): Post
    {
        $this->post->status = Published::class;
        $this->post->published_at = now();
        $this->post->save();

        return $this->post->refresh();
    }
}
