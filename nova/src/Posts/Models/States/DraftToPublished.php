<?php

namespace Nova\Posts\Models\States;

use Nova\Posts\Models\Post;
use Spatie\ModelStates\Transition;

class DraftToPublished extends Transition
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
