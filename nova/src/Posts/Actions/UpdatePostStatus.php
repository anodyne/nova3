<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\DataTransferObjects\PostStatusData;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\Published;

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
