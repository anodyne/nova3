<?php

namespace Nova\Posts\Models\States;

use Nova\Posts\Models\Post;
use Spatie\ModelStates\Transition;

class DraftToPending extends Transition
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): Post
    {
        $this->post->status = Pending::class;
        $this->post->save();

        return $this->post->refresh();
    }
}
