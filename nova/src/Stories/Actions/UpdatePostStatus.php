<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostStatusData;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;

class UpdatePostStatus
{
    use AsAction;

    protected array $statuses = [
        'draft' => Draft::class,
        'pending' => Pending::class,
        'published' => Published::class,
    ];

    public function handle(Post $post, PostStatusData $data): Post
    {
        if ($data->status !== $post->status->name()) {
            $post->status->transitionTo($this->statuses[$data->status]);
        }

        return $post->refresh();
    }
}
