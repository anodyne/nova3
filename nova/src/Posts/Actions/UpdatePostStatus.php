<?php

namespace Nova\Posts\Actions;

use Nova\Posts\DataTransferObjects\PostStatusData;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\Published;

class UpdatePostStatus
{
    protected $statuses = [
        'draft' => Draft::class,
        'pending' => Pending::class,
        'published' => Published::class,
    ];

    public function execute(Post $post, PostStatusData $data): Post
    {
        if ($data->status !== $post->status->name()) {
            $post->status->transitionTo($this->statuses[$data->status]);
        }

        return $post->refresh();
    }
}
